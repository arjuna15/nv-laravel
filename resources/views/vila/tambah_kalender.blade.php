@extends('layout.master')

@section('content')
<div class="container-fluid mt-3">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Tanggal Booking</h3>
        </div>
        <form action="{{ route('vila.storeTanggal') }}" method="POST">
            @csrf
            <input type="hidden" name="vila_id" value="{{ $villa->vila_id }}">

            <div class="card-body">
                <div class="form-group">
                    <label for="no">No Booking</label>
                    <input id="no" name="no" type="text" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nama_tamu">Nama Tamu</label>
                    <input id="nama_tamu" name="nama_tamu" type="text" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="no_hp">No. HP</label>
                    <input id="no_hp" name="no_hp" type="text" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="check_in_date">Tanggal Check-in</label>
                    <input id="check_in_date" name="check_in_date" type="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="check_out_date">Tanggal Check-out</label>
                    <input id="check_out_date" name="check_out_date" type="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="total">Total Biaya</label>
                    <input id="total" name="total" type="text" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="uang_masuk">Uang Masuk (DP)</label>
                    <input id="uang_masuk" name="uang_masuk" type="text" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="sisa">Sisa Pembayaran</label>
                    <input id="sisa" name="sisa" type="text" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="pelunasan">Tanggal Pelunasan</label>
                    <input id="pelunasan" name="pelunasan" type="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="catatan">Catatan</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>

    </div>

    {{-- Daftar Booking --}}
    <div class="card mt-4">
        <div class="card-header bg-info">
            <h3 class="card-title">Daftar Tanggal Sudah Dipesan</h3>
        </div>

        <div class="card-body">
            @if($reservasi->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Tamu</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservasi as $index => $r)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $r->nama_tamu }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->check_in_date)->translatedFormat('d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->check_out_date)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <form action="{{ route('vila.updateStatus', $r['id']) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                                                <option value="Belum Lunas" {{ $r['status'] == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                                <option value="Cicil" {{ $r['status'] == 'Cicil' ? 'selected' : '' }}>Cicil</option>
                                                <option value="Lunas" {{ $r['status'] == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            </select>
                                            <!-- Tombol Modal Cicil -->
                                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#cicilModal{{ $r['id'] }}">
                                                <i class="fas fa-wallet"></i>
                                            </button>
                                        </form>
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
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('vila.invoice', $r->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                            <i class="fas fa-file-invoice"></i> Cetak Invoice
                                        </a>
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
                        </tbody>
                    </table>
                </div>
            @else
                <p><em>Belum ada tanggal yang dipesan.</em></p>
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

        function formatToNumber(value) {
            return parseInt(value.replace(/[^0-9]/g, '')) || 0;
        }

        function hitungSisa() {
            const total = formatToNumber(totalInput.value);
            const dp = formatToNumber(dpInput.value);
            const sisa = total - dp;

            sisaInput.value = sisa < 0 ? 0 : sisa;
        }

        totalInput.addEventListener('input', hitungSisa);
        dpInput.addEventListener('input', hitungSisa);
    });
</script>
@endpush
