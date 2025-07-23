@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">
    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h4 class="h4 mb-0 text-gray-800"><i class="fas fa-home mr-2"></i>Form Tambah / Edit Vila</h4>
    </div>

    <!-- Error Alert -->
    @if ($errors->any())
    <div class="alert alert-danger shadow-sm">
        <strong>Ups! Ada kesalahan input:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @php
        $detail = isset($vila) ? (is_array($vila->detail) ? $vila->detail : json_decode($vila->detail, true)) : [];
        $fasilitas = isset($vila) ? (is_array($vila->fasilitas_vila) ? $vila->fasilitas_vila : json_decode($vila->fasilitas_vila, true)) : [];
        $harga = isset($vila) ? (is_array($vila->harga_villa) ? $vila->harga_villa : json_decode($vila->harga_villa, true)) : [];
    @endphp

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary py-3">
            <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-edit mr-1"></i>Data Vila</h6>
        </div>
        <form action="{{ isset($vila) ? route('vila.update', $vila->vila_id) : route('vila.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($vila)) @method('PUT') @endif

            <div class="card-body">
                <!-- Info Dasar -->
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Nama Vila</label>
                        <input type="text" class="form-control" name="nama_vila" value="{{ old('nama_vila', $vila->nama_vila ?? '') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Lokasi Vila</label>
                        <input type="text" class="form-control" name="lokasi_vila" value="{{ old('lokasi_vila', $vila->lokasi_vila ?? '') }}" required>
                    </div>
                    <div class="form-group col-md-1">
                        <label>Kapasitas Vila</label>
                        <input type="number" class="form-control" name="kapasitas_vila" value="{{ old('kapasitas_vila', $vila->kapasitas_vila ?? '') }}" required>
                    </div>
                    <div class="form-group col-md-1">
                        <label>Villa Owner</label>
                        <select name="is_owner_villa" class="form-control" required>
                            <option value="yes" {{ old('is_owner_villa', $vila->is_owner_villa ?? '') == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('is_owner_villa', $vila->is_owner_villa ?? '') == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                </div>

                <!-- Detail -->
                <hr>
                <h6 class="text-primary mb-3">Detail Vila</h6>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Jumlah Kamar</label>
                        <input type="number" class="form-control" name="detail[jumlah_kamar]" value="{{ old('detail.jumlah_kamar', $detail['jumlah_kamar'] ?? '') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Jumlah Tempat Tidur</label>
                        <input type="number" class="form-control" name="detail[jumlah_tempat_tidur]" value="{{ old('detail.jumlah_tempat_tidur', $detail['jumlah_tempat_tidur'] ?? '') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Jumlah Kamar Mandi</label>
                        <input type="number" class="form-control" name="detail[jumlah_kamar_mandi]" value="{{ old('detail.jumlah_kamar_mandi', $detail['jumlah_kamar_mandi'] ?? '') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Jumlah Parkir Mobil</label>
                        <input type="number" class="form-control" name="detail[jumlah_parkir]" value="{{ old('detail.jumlah_parkir', $detail['jumlah_parkir'] ?? '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Kedalaman & Luas Kolam</label>
                        <input type="text" class="form-control" name="kedalaman_luas_kolam" value="{{ old('kedalaman_luas_kolam', $vila->kedalaman_luas_kolam ?? '') }}">
                    </div>
                    <div class="form-group col-md-9">
                        <label>Fasilitas Tambahan</label>
                        <input type="text" class="form-control" name="fasilitas_tambahan_vila" value="{{ old('fasilitas_tambahan_vila', $vila->fasilitas_tambahan_vila ?? '') }}">
                    </div>
                </div>

                <!-- Harga -->
                <hr>
                <h6 class="text-primary mb-3">Harga Per Hari</h6>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Harga Minggu - Kamis</label>
                        <input type="number" class="form-control" name="harga_villa[minggu_kamis]" value="{{ old('harga_villa.minggu_kamis', $harga['minggu_kamis'] ?? '') }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Harga Jumat</label>
                        <input type="number" class="form-control" name="harga_villa[jumat]" value="{{ old('harga_villa.jumat', $harga['jumat'] ?? '') }}" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Harga Sabtu</label>
                        <input type="number" class="form-control" name="harga_villa[sabtu]" value="{{ old('harga_villa.sabtu', $harga['sabtu'] ?? '') }}" required>
                    </div>
                </div>

                <!-- Upload Gambar -->
                <hr>
                <h6 class="text-primary mb-3">Galeri Gambar</h6>
                <div class="form-group">
                    <label>Upload Gambar (Min 5, Max 50)</label>
                    <input type="file" class="form-control-file" name="gambar[]" multiple>
                    @if(isset($vila) && is_array($vila->gambar))
                    <div class="mt-3 row">
                        @foreach ($vila->gambar as $gambar)
                        <div class="col-md-3 mb-3 text-center">
                            <img src="{{ asset('images/' . ($gambar['image'] ?? $gambar)) }}" width="100%" class="img-thumbnail mb-1">
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" name="hapus_gambar[]" value="{{ $gambar['image'] ?? $gambar }}">
                                <label class="form-check-label small">Hapus</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Fasilitas -->
                <hr>
                <h6 class="text-primary mb-3">Fasilitas Vila</h6>
                <div id="fasilitas-container">
                    @forelse($fasilitas as $f)
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="fasilitas_vila[]" value="{{ $f }}">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger remove-fasilitas"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @empty
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="fasilitas_vila[]" placeholder="Masukkan fasilitas vila">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger remove-fasilitas"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endforelse
                </div>
                <button type="button" id="add-fasilitas" class="btn btn-sm btn-outline-primary mt-2">
                    <i class="fas fa-plus"></i> Tambah Fasilitas
                </button>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save mr-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#add-fasilitas').click(function () {
            $('#fasilitas-container').append(`
                <div class="input-group mb-2">
                    <input type="text" name="fasilitas_vila[]" class="form-control" placeholder="Masukkan fasilitas vila">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-fasilitas"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '.remove-fasilitas', function () {
            $(this).closest('.input-group').remove();
        });
    });
</script>
@endpush
