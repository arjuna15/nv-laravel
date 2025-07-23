@extends('layout.master')

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">📊 Rekap Closing Admin</h1>
    </div>

    <!-- Card Rekap Admin -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">👩‍💼 Rekap Closing per Admin Bulan Ini</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Admin</th>
                            <th>Total Closing Bulan ini</th>
                            <th>Bonus Closing Bulan ini</th>
                            <th>Total Uang Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @forelse ($admin_summary as $admin => $rekap)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $admin }}</td>
                                <td><span class="badge badge-secondary p-2">{{ $rekap['total_closing'] }}</span></td>
                                <td><span class="badge badge-success p-2">{{ $rekap['bonus_closing'] }}</span></td>
                                <td class="text-primary font-weight-bold">Rp {{ number_format($rekap['total_uang_masuk'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-muted">Belum ada data closing bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
