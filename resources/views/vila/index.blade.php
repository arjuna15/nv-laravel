@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 text-gray-800 mb-0">Data Vila</h1>
        <a href="{{ route('vila.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Vila
        </a>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Vila</h6>
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

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-sm mb-0" style="text-align:center" id="villaTable">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 40px;">No</th>
                        <th>ID</th>
                        <th>Nama Vila</th>
                        <th>Lokasi</th>
                        <th>Minggu - Kamis</th>
                        <th>Jumat</th>
                        <th>Sabtu</th>
                        <th class="text-center" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="villaTableBody">
                    @forelse ($vilas as $index => $vila)
                        @php
                            $harga = is_array($vila->harga_villa) ? $vila->harga_villa : json_decode($vila->harga_villa, true);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $vila->vila_id }}</td>
                            <td class="font-weight-bold text-primary">{{ $vila->nama_vila }}</td>
                            <td>{{ $vila->lokasi_vila }}</td>
                            <td>Rp {{ number_format($harga['minggu_kamis'] ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($harga['jumat'] ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($harga['sabtu'] ?? 0, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('vila.edit', $vila->vila_id) }}" class="btn btn-sm btn-warning shadow-sm mr-1">
                                    <i class="fas fa-edit fa-sm"></i>
                                </a>
                                <form action="{{ route('vila.destroy', $vila->vila_id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger shadow-sm">
                                        <i class="fas fa-trash-alt fa-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination justify-content-center mt-3 mb-0" id="pagination"></ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rows = Array.from(document.querySelectorAll('#villaTableBody tr'));
        const pagination = document.getElementById('pagination');
        const searchInput = document.getElementById('searchInput');
        const rowsPerPage = 10;
        let currentPage = 1;

        function displayRows(filteredRows, page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedRows = filteredRows.slice(start, end);

            document.getElementById('villaTableBody').innerHTML = '';

            if (paginatedRows.length > 0) {
                paginatedRows.forEach(row => {
                    document.getElementById('villaTableBody').appendChild(row);
                });
            } else {
                document.getElementById('villaTableBody').innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center text-muted">Data tidak ditemukan.</td>
                    </tr>
                `;
            }
        }

        function setupPagination(filteredRows) {
            pagination.innerHTML = '';
            const pageCount = Math.ceil(filteredRows.length / rowsPerPage);

            if (pageCount <= 1) return; // hide pagination if only one page

            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.classList.add('page-item', 'shadow-sm', 'mx-1');
                if (i === currentPage) li.classList.add('active');

                const a = document.createElement('a');
                a.classList.add('page-link');
                a.href = '#';
                a.textContent = i;
                a.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = i;
                    displayRows(filteredRows, currentPage);
                    setupPagination(filteredRows);
                });

                li.appendChild(a);
                pagination.appendChild(li);
            }
        }

        function filterTable() {
            const query = searchInput.value.toLowerCase();
            const filteredRows = rows.filter(row => {
                return row.textContent.toLowerCase().includes(query);
            });

            currentPage = 1;
            displayRows(filteredRows, currentPage);
            setupPagination(filteredRows);
        }

        // Initial load
        filterTable();

        // Search listener
        searchInput.addEventListener('input', filterTable);
    });
</script>
@endpush
