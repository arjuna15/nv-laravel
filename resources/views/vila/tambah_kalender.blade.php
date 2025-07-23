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
                        <input id="total" name="total" type="number" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="uang_masuk">Uang Masuk (DP)</label>
                        <input id="uang_masuk" name="uang_masuk" type="number" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="sisa">Sisa Pembayaran</label>
                        <input id="sisa" name="sisa" type="number" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="pelunasan">Tanggal Pelunasan</label>
                        <input id="pelunasan" name="pelunasan" type="date" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nama_admin">Nama Admin</label>
                        <select id="nama_admin" name="nama_admin" class="form-control" required>
                            <option value="">-- Pilih Admin --</option>
                            <option value="Junancok">Junancok</option>
                            <option value="Siti Nur Ameliah">Siti Nur Ameliah</option>
                            <option value="Syahrul">Syahrul</option>
                            <option value="Ghafara">Ghafara</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="catatan">Catatan</label>
                        <textarea id="catatan" name="catatan" class="form-control" rows="2"></textarea>
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
                                                <i class="fas fa-times"></i> Cancel
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
    const checkIn = document.getElementById('check_in_date');
    const checkOut = document.getElementById('check_out_date');
    const total = document.getElementById('total');
    const dp = document.getElementById('uang_masuk');
    const sisa = document.getElementById('sisa');
    const pelunasan = document.getElementById('pelunasan');

    function toDateInputValue(date) {
        const offset = date.getTimezoneOffset();
        const localDate = new Date(date.getTime() - (offset * 60 * 1000));
        return localDate.toISOString().split('T')[0];
    }

    checkIn.addEventListener('change', function () {
        // Set check-out besoknya
        if (checkIn.value) {
            let inDate = new Date(checkIn.value);
            let outDate = new Date(inDate);
            outDate.setDate(outDate.getDate() + 1);
            checkOut.value = toDateInputValue(outDate);

            // Hitung tanggal pelunasan
            let today = new Date();
            let daysBefore = Math.ceil((inDate - today) / (1000 * 60 * 60 * 24));

            let pelunasanDate = new Date(inDate);

            if (daysBefore >= 6 && daysBefore <= 5) {
                pelunasanDate.setDate(inDate.getDate() - 2);
            } else if (daysBefore <= 4 && daysBefore >= 1) {
                pelunasanDate = inDate;
            } else {
                pelunasanDate.setDate(inDate.getDate() - 3);
            }

            pelunasan.value = toDateInputValue(pelunasanDate);
        }
    });

    function hitungSisa() {
        const t = parseFloat(total.value) || 0;
        const d = parseFloat(dp.value) || 0;
        const s = t - d;
        sisa.value = s >= 0 ? s : 0;
    }

    total.addEventListener('input', hitungSisa);
    dp.addEventListener('input', hitungSisa);
});
</script>

@endpush

