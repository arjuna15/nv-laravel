@extends('layout.master')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Tambah Vila</h1>

    <div class="row">
        <div class="col-lg-8">

            <!-- Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Vila</h6>
                </div>
                <div class="card-body">

                    <form action="{{ route('vila.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('vila.form')

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('vila.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
