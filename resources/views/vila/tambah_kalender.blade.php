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

@section('content')
<div class="container-fluid mt-3">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">Tambah Tanggal Booking</h6>
        </div>

        <form action="{{ route('vila.storeTanggal') }}" method="POST">
            @csrf
            <input type="hidden" name="vila_id" value="{{ $villa->vila_id }}">

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="no">No Booking</label>
                        <input id="no" name="no" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nama_tamu">Nama Tamu</label>
                        <input id="nama_tamu" name="nama_tamu" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="no_hp">No. HP</label>
                        <input id="no_hp" name="no_hp" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="check_in_date">Tanggal Check-in</label>
                        <input id="check_in_date" name="check_in_date" type="date" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="check_out_date">Tanggal Check-out</label>
                        <input id="check_out_date" name="check_out_date" type="date" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="total">Total Biaya</label>
                        <input id="total" name="total" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="uang_masuk">Uang Masuk (DP)</label>
                        <input id="uang_masuk" name="uang_masuk" type="text" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="sisa">Sisa Pembayaran</label>
                        <input id="sisa" name="sisa" type="text" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="pelunasan">Tanggal Pelunasan</label>
                        <input id="pelunasan" name="pelunasan" type="date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="catatan">Catatan</label>
                        <textarea id="catatan" name="catatan" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="col-md-3">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>


    {{-- Daftar Booking --}}
    <div class="card mt-4 shadow">
    <div class="card-header bg-info text-white">
        <h4 class="mb-0">📅 Daftar Tanggal Sudah Dipesan</h4>
    </div>
        <div class="card-body">
            @if($reservasi->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Tamu</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                                <th>Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservasi as $index => $r)
                                <tr class="text-center align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $r->nama_tamu }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->check_in_date)->translatedFormat('d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->check_out_date)->translatedFormat('d F Y') }}</td>
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
                                        <span class="{{ $badgeClass }} px-3 py-1">{{ $r['status'] }}</span>
                                    </td>
                                    <td>
                                        @csrf
                                        @method('PATCH')

                                        @if($r['status'] !== 'Lunas' && $r['status'] !== 'Batal')
                                            <button class="btn btn-sm btn-success my-1" data-toggle="modal" data-target="#pelunasanModal{{ $r['id'] }}">
                                                <i class="fas fa-check-circle"></i> Pelunasan
                                            </button>

                                            <button class="btn btn-sm btn-secondary my-1" data-toggle="modal" data-target="#cicilModal{{ $r['id'] }}">
                                                <i class="fas fa-wallet"></i> Cicil
                                            </button>
                                        @endif

                                        @if($r['status'] !== 'Batal')
                                            <button class="btn btn-sm btn-danger my-1" data-toggle="modal" data-target="#batalModal{{ $r['id'] }}">
                                                <i class="fas fa-times"></i> Batal
                                            </button>

                                            <button class="btn btn-sm btn-warning my-1" data-toggle="modal" data-target="#pindahModal{{ $r['id'] }}">
                                                <i class="fas fa-random"></i> Pindah
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('vila.cetakInvoicePDF', $r->id) }}" class="btn btn-sm btn-primary mb-1">
                                            <i class="fas fa-file-invoice"></i> Cetak
                                        </a>
                                        <form action="{{ route('vila.destroyTanggal', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Modal (pelunasan, cicil, batal, pindah) tetap ada di sini --}}
                                    <!-- Modal Pelunasan -->
                                            <div class="modal fade" id="pelunasanModal{{ $r['id'] }}" tabindex="-1" role="dialog" aria-labelledby="pelunasanModalLabel{{ $r['id'] }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="{{ route('vila.pelunasan', $r['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Konfirmasi Pelunasan - {{ $r['nama_tamu'] }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin menandai pemesanan ini sebagai <strong>Lunas</strong>?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-success">Ya, Lunas</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>



                                            <!-- Modal Cicil -->
                                            <div class="modal fade" id="cicilModal{{ $r['id'] }}" tabindex="-1" role="dialog" aria-labelledby="cicilModalLabel{{ $r['id'] }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="{{ route('vila.cicil', $r['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Tambah Cicilan - {{ $r['nama_tamu'] }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Jumlah Cicilan</label>
                                                                    <input type="number" name="jumlah" class="form-control" min="1" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Ubah Tanggal Pelunasan (Opsional)</label>
                                                                    <input type="date" name="pelunasan" class="form-control" value="{{ $r['pelunasan'] }}">
                                                                </div>
                                                            </div>                                                    
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- Modal Batal -->
                                            <div class="modal fade" id="batalModal{{ $r['id'] }}" tabindex="-1" role="dialog" aria-labelledby="batalModalLabel{{ $r['id'] }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="{{ route('vila.updateStatus', $r['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="Batal">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Pembatalan Reservasi - {{ $r['nama_tamu'] }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Catatan Pembatalan</label>
                                                                    <textarea name="catatan" class="form-control" rows="3" required placeholder="Isi alasan pembatalan..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-danger">Konfirmasi Batal</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                                <div class="modal fade" id="pindahModal{{ $r['id'] }}" tabindex="-1" role="dialog" aria-labelledby="pindahModalLabel{{ $r['id'] }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="{{ route('vila.pindah', $r['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Pindah Villa / Tanggal - {{ $r['nama_tamu'] }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- <div class="form-group">
                                                                    <label>Villa Baru</label>
                                                                    <select name="villa_id_baru" class="form-control" required>
                                                                        <option value="">-- Pilih Villa --</option>
                                                                        @foreach($villas as $villa)
                                                                            <option value="{{ $villa->id }}" {{ $villa->id == $r['vila_id'] ? 'disabled' : '' }}>
                                                                                {{ $villa->nama_vila }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div> -->
                                                                <div class="form-group">
                                                                    <label>Tanggal Check-in Baru</label>
                                                                    <input type="date" name="checkin_baru" class="form-control" value="{{ $r['check_in_date'] }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Tanggal Check-out Baru</label>
                                                                    <input type="date" name="checkout_baru" class="form-control" value="{{ $r['check_out_date'] }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Catatan (Opsional)</label>
                                                                    <textarea name="catatan" class="form-control" rows="2" placeholder="Tulis alasan atau catatan jika perlu..."></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Total</label>
                                                                    <input type="number" name="total" class="form-control" value="{{ $r['total'] }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Uang Masuk</label>
                                                                    <input type="number" name="uang_masuk" class="form-control" value="{{ $r['uang_masuk'] }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Sisa</label>
                                                                    <input type="number" name="sisa" class="form-control" value="{{ $r['sisa'] }}" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Pelunasan</label>
                                                                    <input type="date" name="pelunasan" class="form-control" value="{{ $r['pelunasan'] }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                    {{-- ⬇ Tidak saya tampilkan ulang karena kamu sudah berikan semua di atas ⬇ --}}
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center"><em>Belum ada tanggal yang dipesan.</em></p>
            @endif
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

