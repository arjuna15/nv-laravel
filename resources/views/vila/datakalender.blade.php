@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">

    <!-- Heading -->
    <h1 class="h3 mb-4 text-gray-800">📋 Data Bookingan Vila</h1>


    <!-- Table Booking -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">
                📌 Daftar Bookingan
            </h6>
        </div>
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <div class="input-group w-50">
                <input 
                    type="text" 
                    id="searchInput" 
                    class="form-control bg-light border-0 small shadow-sm" 
                    placeholder="Cari Nama Vila..."
                    autocomplete="off"
                >
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="villaTable">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Vila</th>
                            <th>Nama Vila</th>
                            <th>Jumlah Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="villaTableBody">
                        @foreach($villa as $index => $v)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $v['vila_id'] }}</td>
                                <td>{{ $v['nama_vila'] }}</td>
                                <td>
                                    <span class="badge badge-info px-3 py-2 shadow-sm">
                                        {{ $v['total_booking'] }} Booking
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('vila.tambahTanggal', ['vila_id' => $v['vila_id']]) }}" 
                                    class="btn btn-sm btn-warning shadow-sm">
                                        <i class="fas fa-calendar-plus"></i> Cek
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination justify-content-center" id="pagination"></ul>
            </nav>
        </div>
    </div>

    <!-- Card: Tamu Booking Hari Ini -->
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white py-3">
            <h6 class="m-0 font-weight-bold">📅 Daftar Tamu Booking Hari Ini</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-light">
                    <tr>
                        <th>No Booking</th>
                        <th>Nama Tamu</th>
                        <th>Nama Villa</th>
                        <th>Check-in</th>
                        <th>Total</th>
                        <th>Uang Masuk</th>
                        <th>Sisa</th>
                        <th>Pelunasan</th>
                        <th>Catatan</th>
                        <th>No HP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($villa as $v)
                        @foreach($v['today_bookings'] as $b)
                            <tr>
                                <td>{{ $b['no'] }}</td>
                                <td>{{ $b['nama_tamu'] }}</td>
                                <td>{{ $v['nama_vila'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($b['check_in'])->translatedFormat('d F Y') }}</td>
                                <td>Rp {{ number_format($b['total'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($b['uang_masuk'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($b['sisa'], 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($b['pelunasan'])->translatedFormat('d F Y') }}</td>
                                <td>{{ $b['catatan'] }}</td>
                                <td>{{ $b['no_hp'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card: Pelunasan Hari Ini -->
    <div class="card shadow mb-4">
        <div class="card-header bg-warning text-white py-3">
            <h6 class="m-0 font-weight-bold">💰 Daftar Tamu Pelunasan Hari Ini</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped text-center">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>No Booking</th>
                        <th>Nama Tamu</th>
                        <th>Nama Villa</th>
                        <th>Check-in</th>
                        <th>Sisa</th>
                        <th>Pelunasan</th>
                        <th>Catatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($villa as $v)
                        @foreach($v['unpaid_pelunasan'] as $p)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $p['no'] }}</td>
                                <td>{{ $p['nama_tamu'] }}</td>
                                <td>{{ $v['nama_vila'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($p['check_in'])->translatedFormat('d F Y') }}</td>
                                <td>{{ $p['catatan'] }}</td>
                                <td>Rp {{ number_format($p['sisa'], 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p['pelunasan'])->translatedFormat('d F Y') }}</td>
                                <td>
                                        @csrf
                                        @method('PATCH')

                                        @if($p['status'] !== 'Lunas' && $p['status'] !== 'Batal')
                                            <button class="btn btn-sm btn-success my-1" data-toggle="modal" data-target="#pelunasanModal{{ $p['id'] }}">
                                                <i class="fas fa-check-circle"></i> Pelunasan
                                            </button>

                                            <button class="btn btn-sm btn-secondary my-1" data-toggle="modal" data-target="#cicilModal{{ $p['id'] }}">
                                                <i class="fas fa-wallet"></i> Cicil
                                            </button>
                                        @endif

                                        @if($p['status'] !== 'Batal')
                                            <button class="btn btn-sm btn-danger my-1" data-toggle="modal" data-target="#batalModal{{ $p['id'] }}">
                                                <i class="fas fa-times"></i> Batal
                                            </button>

                                            <button class="btn btn-sm btn-warning my-1" data-toggle="modal" data-target="#pindahModal{{ $p['id'] }}">
                                                <i class="fas fa-random"></i> Pindah
                                            </button>
                                        @endif
                                </td>
                                {{-- Modal (pelunasan, cicil, batal, pindah) tetap ada di sini --}}
                                    <!-- Modal Pelunasan -->
                                <div class="modal fade" id="pelunasanModal{{ $p['id'] }}" tabindex="-1" role="dialog" aria-labelledby="pelunasanModalLabel{{ $p['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('vila.pelunasan', $p['id']) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Pelunasan - {{ $p['nama_tamu'] }}</h5>
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
                                <div class="modal fade" id="cicilModal{{ $p['id'] }}" tabindex="-1" role="dialog" aria-labelledby="cicilModalLabel{{ $p['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('vila.cicil', $p['id']) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Cicilan - {{ $p['nama_tamu'] }}</h5>
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
                                                        <input type="date" name="pelunasan" class="form-control" value="{{ $p['pelunasan'] }}">
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
                                <div class="modal fade" id="batalModal{{ $p['id'] }}" tabindex="-1" role="dialog" aria-labelledby="batalModalLabel{{ $p['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('vila.updateStatus', $p['id']) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Batal">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Pembatalan Reservasi - {{ $p['nama_tamu'] }}</h5>
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
                                    <div class="modal fade" id="pindahModal{{ $p['id'] }}" tabindex="-1" role="dialog" aria-labelledby="pindahModalLabel{{ $p['id'] }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('vila.pindah', $p['id']) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Pindah Villa / Tanggal - {{ $p['nama_tamu'] }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label>Tanggal Check-in Baru</label>
                                                        <input type="date" name="checkin_baru" class="form-control" value="{{ $p['check_in'] }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Check-out Baru</label>
                                                        <input type="date" name="checkout_baru" class="form-control" value="{{ $p['check_out'] }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Catatan (Opsional)</label>
                                                        <textarea name="catatan" class="form-control" rows="2" placeholder="Tulis alasan atau catatan jika perlu..."></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Total</label>
                                                        <input type="number" name="total" class="form-control" value="{{ $p['total'] }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Uang Masuk</label>
                                                        <input type="number" name="uang_masuk" class="form-control" value="{{ $p['uang_masuk'] }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Sisa</label>
                                                        <input type="number" name="sisa" class="form-control" value="{{ $p['sisa'] }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pelunasan</label>
                                                        <input type="date" name="pelunasan" class="form-control" value="{{ $p['pelunasan'] }}" required>
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
                            </tr>
                        @endforeach
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
        const rowsPerPage = 10;
        let currentPage = 1;
        const table = document.getElementById('villaTable');
        const tableBody = document.getElementById('villaTableBody');
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        const pagination = document.getElementById('pagination');
        const searchInput = document.getElementById('searchInput');

        function renderTable(filteredRows) {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            tableBody.innerHTML = '';
            filteredRows.slice(start, end).forEach(row => {
                tableBody.appendChild(row);
            });
        }

        function renderPagination(filteredRows) {
            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
            pagination.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.classList.add('page-item');
                if (i === currentPage) li.classList.add('active');
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', function (e) {
                    e.preventDefault();
                    currentPage = i;
                    renderTable(filteredRows);
                    renderPagination(filteredRows);
                });
                pagination.appendChild(li);
            }
        }

        function filterRows() {
            const query = searchInput.value.toLowerCase();
            const filteredRows = rows.filter(row => {
                const namaVila = row.cells[2].textContent.toLowerCase();
                const lokasi = row.cells[2].textContent.toLowerCase(); // jika ada lokasi
                return namaVila.includes(query) || lokasi.includes(query);
            });
            currentPage = 1; // reset ke halaman pertama
            renderTable(filteredRows);
            renderPagination(filteredRows);
        }

        // Initial render
        filterRows();

        // Search on input
        searchInput.addEventListener('input', filterRows);
    });
</script>

@endpush
