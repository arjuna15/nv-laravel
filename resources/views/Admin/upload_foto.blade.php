
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
            
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Upload Foto</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Upload Foto</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.updateImages') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="images">Pilih Foto</label>
                                                <input type="hidden" name="id" value="{{ $datavilla->villa_id }}"> 
                                                <input type="file" id="images" class="form-control" name="images[]" multiple>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-first">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Upload</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Basic multiple Column Form section end -->
    </div>
</div>

@push('scripts')
<script src="{{ asset('new_admin/dist/assets/static/js/components/dark.js') }}"></script>
<script src="{{ asset('new_admin/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('new_admin/dist/assets/compiled/js/app.js') }}"></script>
@endpush
