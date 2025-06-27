@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h4>Tambah Vila</h4>

    <form action="{{ route('vila.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('vila.form')

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('vila.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
