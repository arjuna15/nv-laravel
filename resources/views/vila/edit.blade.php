@extends('layout.master')

@section('content')
<div class="container mt-4">
    <h4>Edit Vila</h4>

    <form action="{{ route('vila.update', $vila->vila_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('vila.form', ['vila' => $vila])

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('vila.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
