@extends('layout.master')
<style>
    .status-badge {
    display: inline-block;
    width: 100px;         /* lebar badge biar seragam */
    text-align: center;
    font-weight: bold;
    padding: 5px 0;
    border-radius: 5px;
    font-size: 13px;
}

</style>

@section('title', 'Detail Tanggal Booking')

@section('content')
<div class="card mt-4">
    <div class="card-header bg-info">
        <h4 class="card-title mb-0">Reservasi Bulan: {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light text-center">
                    <tr>
                        <th>No Booking</th>
                        <th>Nama Tamu</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Uang Masuk</th>
                        <th>Sisa</th>
                        <th>Pelunasan</th>
                        <th>Catatan</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calendarData as $item)
                        @php
                            $tgl = \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d');
                            $data = $item['data'];
                        @endphp

                        @if ($data->count())
                            @foreach ($data as $r)
                                <tr class="text-center">
                                    <td>{{ $r['no'] }}</td>
                                    <td>{{ $r['nama_tamu'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r['check_in_date'])->translatedFormat('d F Y') }}</td>
                                    <td>Rp {{ number_format($r['total'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($r['uang_masuk'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($r['sisa'], 0, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r['pelunasan'])->translatedFormat('d F Y') }}</td>
                                    <td>{{ $r['catatan'] }}</td>
                                    <td>{{ $r['no_hp'] }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($r['status']) {
                                                'Belum Lunas' => 'badge badge-warning',
                                                'Cicil'       => 'badge badge-info',
                                                'Lunas'       => 'badge badge-success',
                                                'Batal'       => 'badge badge-danger',
                                                default       => 'badge badge-secondary',
                                            };
                                        @endphp
                                        <span class="{{ $badgeClass }}">{{ $r['status'] }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('vila.destroyTanggal', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center text-muted">
                                <td>{{ $tgl }}</td>
                                <td colspan="10"><em>Tidak ada reservasi</em></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkInInput = document.getElementById('check_in_date');
        const checkOutInput = document.getElementById('check_out_date');

        checkInInput.addEventListener('change', function () {
            if (checkInInput.value) {
                const checkInDate = new Date(checkInInput.value);
                checkInDate.setDate(checkInDate.getDate() + 1);

                const year = checkInDate.getFullYear();
                const month = String(checkInDate.getMonth() + 1).padStart(2, '0');
                const day = String(checkInDate.getDate()).padStart(2, '0');

                checkOutInput.value = `${year}-${month}-${day}`;
            }
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const totalInput = document.getElementById('total');
    const dpInput = document.getElementById('uang_masuk');
    const sisaInput = document.getElementById('sisa');
    const checkInInput = document.getElementById('check_in_date');
    const pelunasanInput = document.getElementById('pelunasan');

    function formatToNumber(value) {
        return parseInt(value.replace(/[^0-9]/g, '')) || 0;
    }

    function hitungSisa() {
        const total = formatToNumber(totalInput.value);
        const dp = formatToNumber(dpInput.value);
        const sisa = total - dp;
        sisaInput.value = sisa < 0 ? 0 : sisa;
    }

    function aturTanggalPelunasan() {
        const checkInValue = checkInInput.value;
        if (!checkInValue) return;

        const checkInDate = new Date(checkInValue);
        const today = new Date();

        // Buat versi tanpa waktu agar akurat
        checkInDate.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);

        const diffTime = checkInDate.getTime() - today.getTime();
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); // selisih hari

        let pelunasanDate;

        if (diffDays === 6 || diffDays === 5) {
            // H-6 atau H-5 → pelunasan H-2
            pelunasanDate = new Date(checkInDate);
            pelunasanDate.setDate(checkInDate.getDate() - 1);
        } else if (diffDays <= 3 && diffDays >= 1) {
            // H-3, H-2, H-1 → pelunasan = hari H
            pelunasanDate = new Date(checkInDate);
        } else {
            // Default: pelunasan H-3
            pelunasanDate = new Date(checkInDate);
            pelunasanDate.setDate(checkInDate.getDate() - 2);
        }

        // Format YYYY-MM-DD
        const formatted = pelunasanDate.toISOString().split('T')[0];
        pelunasanInput.value = formatted;
    }

    totalInput.addEventListener('input', hitungSisa);
    dpInput.addEventListener('input', hitungSisa);
    checkInInput.addEventListener('change', aturTanggalPelunasan);
});
</script>


@endpush
