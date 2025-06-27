@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h4>Data Vila</h4>

    <a href="{{ route('vila.create') }}" class="btn btn-primary mb-3">Tambah Vila</a>

    {{-- Form Pencarian --}}
    <form action="{{ route('vila.index') }}" method="GET" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Cari Nama atau Lokasi" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Vila</th>
                <th>Nama Vila</th>
                <th>Lokasi</th>
                <th>Harga Minggu - Kamis</th>
                <th>Harga Jumat</th>
                <th>Harga Sabtu</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vilas as $index => $vila)
            <tr>
                <td>{{ $vilas->firstItem() + $index }}</td>
                <td>{{ $vila->vila_id }}</td>
                <td>{{ $vila->nama_vila }}</td>
                <td>{{ $vila->lokasi_vila }}</td>
                <td>Rp {{ number_format($vila->harga_minggu_kamis, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($vila->harga_jumat, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($vila->harga_sabtu, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('vila.edit', $vila->vila_id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('vila.destroy', $vila->vila_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    {{ $vilas->withQueryString()->links() }}

</div>
@endsection
