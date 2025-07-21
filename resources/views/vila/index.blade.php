@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">

    <!-- Judul dan Tombol Tambah -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800">Data Vila</h1>
        <a href="{{ route('vila.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Vila
        </a>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-body">

            {{-- Form Pencarian --}}
            <form action="{{ route('vila.index') }}" method="GET" class="mb-3">
                <div class="input-group w-50">
                    <input type="text" name="search" class="form-control bg-light border-1 small"
                           placeholder="Cari Nama atau Lokasi" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tabel Data --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Vila</th>
                            <th>Nama Vila</th>
                            <th>Lokasi</th>
                            <th>Harga Minggu - Kamis</th>
                            <th>Harga Jumat</th>
                            <th>Harga Sabtu</th>
                            <th class="text-center" style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vilas as $index => $vila)
                            @php
                                $harga = is_array($vila->harga_villa) ? $vila->harga_villa : json_decode($vila->harga_villa, true);
                            @endphp
                            <tr>
                                <td>{{ $vilas->firstItem() + $index }}</td>
                                <td>{{ $vila->vila_id }}</td>
                                <td>{{ $vila->nama_vila }}</td>
                                <td>{{ $vila->lokasi_vila }}</td>
                                <td>Rp {{ number_format($harga['minggu_kamis'] ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($harga['jumat'] ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($harga['sabtu'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('vila.edit', $vila->vila_id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('vila.destroy', $vila->vila_id) }}" method="POST"
                                          class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @if ($vilas->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center text-muted">Data tidak ditemukan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $vilas->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
