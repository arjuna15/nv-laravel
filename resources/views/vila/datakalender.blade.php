@extends('layout.master')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Vila</h3>
            <div class="card-tools">
                <a href="{{ route('vila.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Vila
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Form Pencarian --}}
            <form action="{{ route('vila.index') }}" method="GET" class="form-inline mb-3">
                <div class="input-group w-50">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama atau Lokasi" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tabel --}}
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>ID Vila</th>
                        <th>Nama Vila</th>
                        <th>Jumlah Booking</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($villa as $index => $villas)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $villas['vila_id'] }}</td>
                            <td>{{ $villas['nama_vila'] }}</td>
                            <td>
                                <span class="badge badge-info">{{ count($villas['jumlah_reserv']) }} Booking</span>
                            </td>
                            <td>
                                <a href="{{ route('vila.tambahTanggal', ['vila_id' => $villas['vila_id']]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-calendar-plus"></i> Tanggal
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            {{-- Tambahkan jika pakai pagination --}}
            {{-- {{ $villa->links() }} --}}
        </div>
    </div>
</div>
@endsection
