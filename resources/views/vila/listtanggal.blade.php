@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">

    <!-- Heading -->
    <h1 class="h3 mb-4 text-gray-800">📋 Data Bookingan Vila</h1>
    <!-- Table Booking -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">📌 Daftar Bookingan</h6>
        </div>
        <div class="card-body">
            <div class="input-group w-50 mb-3">
                <input 
                    type="text" 
                    id="searchInput" 
                    class="form-control bg-light border-0 small shadow-sm" 
                    placeholder="🔍 Cari Nama atau Lokasi..." 
                    autocomplete="off"
                >
                <div class="input-group-append">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-search"></i>
                    </span>
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
                        @foreach($datas as $index => $v)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $v['vila_id'] }}</td>
                                <td>{{ $v['nama_vila'] }}</td>
                                <td>
                                    <span class="badge badge-info px-3 py-2">{{ $v['total_booking'] }} Booking</span>
                                </td>
                                <td>
                                    <a href="{{ route('vila.tanggalOnly', ['vila_id' => $v['vila_id']]) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-calendar-plus"></i> Cek
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
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
        const rowsPerPage = 10; // jumlah data per halaman
        let currentPage = 1;

        function displayRows(filteredRows, page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedRows = filteredRows.slice(start, end);

            document.getElementById('villaTableBody').innerHTML = '';

            paginatedRows.forEach(row => {
                document.getElementById('villaTableBody').appendChild(row);
            });
        }

        function setupPagination(filteredRows) {
            pagination.innerHTML = '';
            const pageCount = Math.ceil(filteredRows.length / rowsPerPage);

            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement('li');
                li.classList.add('page-item');
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

            currentPage = 1; // reset ke halaman 1 saat filter
            displayRows(filteredRows, currentPage);
            setupPagination(filteredRows);
        }

        // Load awal
        filterTable();

        // Search realtime
        searchInput.addEventListener('input', filterTable);
    });
</script>
@endpush
