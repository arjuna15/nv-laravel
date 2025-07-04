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
            <form action="{{ route('vila.index') }}" method="GET" class="mb-3">
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
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Vila</th>
                            <th>Nama Vila</th>
                            <th>Lokasi</th>
                            <th>Harga Minggu - Kamis</th>
                            <th>Harga Jumat</th>
                            <th>Harga Sabtu</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vilas as $index => $vila)
                            <tr>
                                <td>{{ $vilas->firstItem() + $index }}</td>
                                <td>{{ $vila->vila_id }}</td>
                                <td>{{ $vila->nama_vila }}</td>
                                <td>{{ $vila->lokasi_vila }}</td>
                                <td>Rp {{ number_format($vila->harga_villa['minggu_kamis'] ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($vila->harga_villa['jumat'] ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($vila->harga_villa['sabtu'] ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('vila.edit', $vila->vila_id) }}" class="btn btn-warning btn-sm mb-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('vila.destroy', $vila->vila_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $vilas->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
