@extends('layout.master')

@section('title', 'Detail Tanggal Booking')

@push('styles')
<style>
    .status-badge {
        font-weight: 600;
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 20px;
        display: inline-block;
        min-width: 90px;
        text-transform: uppercase;
    }

    .table-hover tbody tr:hover {
        background-color: #f0f4ff;
    }

    .card-title {
        font-weight: 600;
        font-size: 1.4rem;
    }

    .btn-sm i {
        margin-right: 5px;
    }

    .table th, .table td {
        vertical-align: middle !important;
        font-size: 14px;
        padding: 12px 8px;
    }

    .card-header h5 {
        font-weight: bold;
    }

    .btn-outline-primary {
        font-weight: 500;
    }

    .text-muted em {
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow border-0">
        @php
            $prev = $bulan->copy()->subMonth()->format('Y-m');
            $next = $bulan->copy()->addMonth()->format('Y-m');
        @endphp

        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <a href="{{ request()->url() . '?month=' . $prev }}" class="btn btn-sm btn-outline-primary shadow-sm">
                <i class="fas fa-chevron-left"></i> Bulan Sebelumnya
            </a>
            <h5 class="text-primary mb-0">
                <i class="far fa-calendar-alt mr-1"></i> {{ $bulan->translatedFormat('F Y') }}
            </h5>
            <a href="{{ request()->url() . '?month=' . $next }}" class="btn btn-sm btn-outline-primary shadow-sm">
                Bulan Selanjutnya <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
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
                                    <tr>
                                        <td>{{ $r['no'] }}</td>
                                        <td>{{ $r['nama_tamu'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($r['check_in_date'])->translatedFormat('d F Y') }}</td>
                                        <td>Rp {{ number_format($r['total'], 0, ',', '.') }}</td>
                                        <td class="text-success">Rp {{ number_format($r['uang_masuk'], 0, ',', '.') }}</td>
                                        <td class="text-danger">Rp {{ number_format($r['sisa'], 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($r['pelunasan'])->translatedFormat('d F Y') }}</td>
                                        <td>{{ $r['catatan'] }}</td>
                                        <td>{{ $r['no_hp'] }}</td>
                                        <td>
                                           @php
                                                $status = $r['status'] ?? 'unknown';
                                            @endphp

                                            @switch($status)
                                                @case('Lunas')
                                                    <span class="badge badge-success px-3 py-2 rounded-pill">Lunas</span>
                                                    @break
                                                @case('Belum Lunas')
                                                    <span class="badge badge-warning px-3 py-2 rounded-pill">Belum Lunas</span>
                                                    @break
                                                @case('Cicil')
                                                    <span class="badge badge-primary px-3 py-2 rounded-pill">Cicil</span>
                                                    @break
                                                @case('Batal')
                                                    <span class="badge badge-danger px-3 py-2 rounded-pill">Cancel</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-secondary px-3 py-2 rounded-pill">Tidak Diketahui</span>
                                            @endswitch

                                        </td>
                                        <td>
                                            <form action="{{ route('vila.destroyTanggal', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-muted">
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
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkInInput = document.getElementById('check_in_date');
        const checkOutInput = document.getElementById('check_out_date');
        const totalInput = document.getElementById('total');
        const dpInput = document.getElementById('uang_masuk');
        const sisaInput = document.getElementById('sisa');
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

            checkInDate.setHours(0, 0, 0, 0);
            today.setHours(0, 0, 0, 0);

            const diffDays = Math.ceil((checkInDate - today) / (1000 * 60 * 60 * 24));
            let pelunasanDate = new Date(checkInDate);

            if ([5, 6].includes(diffDays)) {
                pelunasanDate.setDate(checkInDate.getDate() - 1);
            } else if (diffDays <= 3 && diffDays >= 1) {
                // Hari H
            } else {
                pelunasanDate.setDate(checkInDate.getDate() - 2);
            }

            pelunasanInput.value = pelunasanDate.toISOString().split('T')[0];
        }

        if (totalInput && dpInput && sisaInput) {
            totalInput.addEventListener('input', hitungSisa);
            dpInput.addEventListener('input', hitungSisa);
        }

        if (checkInInput && pelunasanInput) {
            checkInInput.addEventListener('change', aturTanggalPelunasan);
        }

        if (checkInInput && checkOutInput) {
            checkInInput.addEventListener('change', function () {
                if (checkInInput.value) {
                    const checkInDate = new Date(checkInInput.value);
                    checkInDate.setDate(checkInDate.getDate() + 1);
                    checkOutInput.value = checkInDate.toISOString().split('T')[0];
                }
            });
        }
    });
</script>
@endpush
