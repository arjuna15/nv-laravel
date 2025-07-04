@extends('layout.master')

@section('content')
<div class="container-fluid mt-3">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Tambah / Edit Vila</h3>
        </div>

        <form action="{{ isset($vila) ? route('vila.update', $vila->vila_id) : route('vila.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($vila)) @method('PUT') @endif

            <div class="card-body">
                {{-- Info Dasar --}}
                <div class="form-group">
                    <label>Nama Vila</label>
                    <input type="text" class="form-control" name="nama_vila" value="{{ old('nama_vila', $vila->nama_vila ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Lokasi Vila</label>
                    <input type="text" class="form-control" name="lokasi_vila" value="{{ old('lokasi_vila', $vila->lokasi_vila ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Kapasitas Vila</label>
                    <input type="number" class="form-control" name="kapasitas_vila" value="{{ old('kapasitas_vila', $vila->kapasitas_vila ?? '') }}" required>
                </div>

                {{-- Detail --}}
                <div class="row">
                    <div class="col-md-6">
                        <label>Jumlah Kamar</label>
                        <input type="number" class="form-control" name="detail[jumlah_kamar]" value="{{ old('detail.jumlah_kamar', $vila->detail['jumlah_kamar'] ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Jumlah Tempat Tidur</label>
                        <input type="number" class="form-control" name="detail[jumlah_tempat_tidur]" value="{{ old('detail.jumlah_tempat_tidur', $vila->detail['jumlah_tempat_tidur'] ?? '') }}">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Jumlah Kamar Mandi</label>
                        <input type="number" class="form-control" name="detail[jumlah_kamar_mandi]" value="{{ old('detail.jumlah_kamar_mandi', $vila->detail['jumlah_kamar_mandi'] ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Jumlah Parkir Mobil</label>
                        <input type="number" class="form-control" name="detail[jumlah_parkir]" value="{{ old('detail.jumlah_parkir', $vila->detail['jumlah_parkir'] ?? '') }}">
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label>Kedalaman & Luas Kolam</label>
                    <input type="text" class="form-control" name="kedalaman_luas_kolam" value="{{ old('kedalaman_luas_kolam', $vila->kedalaman_luas_kolam ?? '') }}">
                </div>

                {{-- Fasilitas --}}
                <div class="form-group">
                    <label>Fasilitas Tambahan</label>
                    <textarea class="form-control" name="fasilitas_tambahan_vila">{{ old('fasilitas_tambahan_vila', $vila->fasilitas_tambahan_vila ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Fasilitas Vila</label>
                    <div id="fasilitas-container">
                        @if(isset($vila) && $vila->fasilitas_vila)
                            @foreach($vila->fasilitas_vila as $fasilitas)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="fasilitas_vila[]" value="{{ $fasilitas }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger remove-fasilitas">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="fasilitas_vila[]" placeholder="Masukkan fasilitas vila">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger remove-fasilitas">Hapus</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-fasilitas" class="btn btn-sm btn-primary mt-2">Tambah Fasilitas</button>
                </div>

                {{-- Harga --}}
                <div class="form-group">
                    <label>Harga Minggu - Kamis</label>
                    <input type="number" class="form-control" name="harga_villa[minggu_kamis]" value="{{ old('harga_villa.minggu_kamis', $vila->harga_villa['minggu_kamis'] ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Harga Jumat</label>
                    <input type="number" class="form-control" name="harga_villa[jumat]" value="{{ old('harga_villa.jumat', $vila->harga_villa['jumat'] ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label>Harga Sabtu</label>
                    <input type="number" class="form-control" name="harga_villa[sabtu]" value="{{ old('harga_villa.sabtu', $vila->harga_villa['sabtu'] ?? '') }}" required>
                </div>

                {{-- Upload Gambar --}}
                <div class="form-group">
                    <label>Upload Gambar (Minimal 5, Maksimal 50)</label>
                    <input type="file" class="form-control" name="gambar[]" multiple>
                    @if (isset($vila) && is_array($vila->gambar))
                        <div class="mt-3 row">
                            @foreach ($vila->gambar as $gambar)
                                <div class="col-md-3 mb-2">
                                    <img src="{{ asset('storage/' . $gambar) }}" width="100" class="img-thumbnail mb-1">
                                    <div>
                                        <label>
                                            <input type="checkbox" name="hapus_gambar[]" value="{{ $gambar }}"> Hapus
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Tambah Fasilitas
        $('#add-fasilitas').click(function () {
            $('#fasilitas-container').append(`
                <div class="input-group mb-2">
                    <input type="text" name="fasilitas_vila[]" class="form-control" placeholder="Masukkan fasilitas vila">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-fasilitas">Hapus</button>
                    </div>
                </div>
            `);
        });

        // Hapus Fasilitas
        $(document).on('click', '.remove-fasilitas', function () {
            $(this).closest('.input-group').remove();
        });
    });
</script>
@endpush
