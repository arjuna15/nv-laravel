<div class="form-group">
    <label>Nama Vila</label>
    <input type="text" name="nama_vila" class="form-control" value="{{ old('nama_vila', $vila->nama_vila ?? '') }}">
</div>

<div class="form-group">
    <label>Lokasi Vila</label>
    <input type="text" name="lokasi_vila" class="form-control" value="{{ old('lokasi_vila', $vila->lokasi_vila ?? '') }}">
</div>

<div class="form-group">
    <label>Kapasitas Vila</label>
    <input type="number" name="kapasitas_vila" class="form-control" value="{{ old('kapasitas_vila', $vila->kapasitas_vila ?? '') }}">
</div>

<div class="form-group">
    <label>Jumlah Kamar Tidur</label>
    <input type="number" name="jumlah_kamar_tidur" class="form-control" value="{{ old('jumlah_kamar_tidur', $vila->jumlah_kamar_tidur ?? '') }}">
</div>

<div class="form-group">
    <label>Jumlah Tempat Tidur</label>
    <input type="number" name="jumlah_tempat_tidur" class="form-control" value="{{ old('jumlah_tempat_tidur', $vila->jumlah_tempat_tidur ?? '') }}">
</div>

<div class="form-group">
    <label>Jumlah Kamar Mandi</label>
    <input type="number" name="jumlah_kamar_mandi" class="form-control" value="{{ old('jumlah_kamar_mandi', $vila->jumlah_kamar_mandi ?? '') }}">
</div>

<div class="form-group">
    <label>Jumlah Area Parkir Mobil</label>
    <input type="number" name="jumlah_area_parkir_mobil" class="form-control" value="{{ old('jumlah_area_parkir_mobil', $vila->jumlah_area_parkir_mobil ?? '') }}">
</div>

<div class="form-group">
    <label>Jumlah Area Parkir Bus</label>
    <select name="jumlah_area_parkir_bus" class="form-control">
        <option value="Ya" {{ (old('jumlah_area_parkir_bus', $vila->jumlah_area_parkir_bus ?? '') == 'Ya') ? 'selected' : '' }}>Ya</option>
        <option value="Tidak" {{ (old('jumlah_area_parkir_bus', $vila->jumlah_area_parkir_bus ?? '') == 'Tidak') ? 'selected' : '' }}>Tidak</option>
    </select>
</div>

<div class="form-group">
    <label>Kedalaman/Luas Kolam</label>
    <input type="text" name="kedalaman_luas_kolam" class="form-control" value="{{ old('kedalaman_luas_kolam', $vila->kedalaman_luas_kolam ?? '') }}">
</div>

<div class="form-group">
    <label>Fasilitas Tambahan Vila</label>
    <textarea name="fasilitas_tambahan_vila" class="form-control">{{ old('fasilitas_tambahan_vila', $vila->fasilitas_tambahan_vila ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Fasilitas Vila</label>
    <div id="fasilitas-container">
        @if(isset($vila) && $vila->fasilitas_vila)
            @foreach(json_decode($vila->fasilitas_vila) as $fasilitas)
                <div class="input-group mb-2">
                    <input type="text" name="fasilitas_vila[]" class="form-control" value="{{ $fasilitas }}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger remove-fasilitas">Hapus</button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="input-group mb-2">
                <input type="text" name="fasilitas_vila[]" class="form-control" placeholder="Masukkan fasilitas vila">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-fasilitas">Hapus</button>
                </div>
            </div>
        @endif
    </div>
    <button type="button" id="add-fasilitas" class="btn btn-primary mt-2">Tambah Fasilitas</button>
</div>

<div class="form-group">
    <label>Harga Minggu - Kamis</label>
    <input type="number" name="harga_minggu_kamis" class="form-control" value="{{ old('harga_minggu_kamis', $vila->harga_minggu_kamis ?? '') }}">
</div>

<div class="form-group">
    <label>Harga Jumat</label>
    <input type="number" name="harga_jumat" class="form-control" value="{{ old('harga_jumat', $vila->harga_jumat ?? '') }}">
</div>

<div class="form-group">
    <label>Harga Sabtu</label>
    <input type="number" name="harga_sabtu" class="form-control" value="{{ old('harga_sabtu', $vila->harga_sabtu ?? '') }}">
</div>

<div class="form-group">
    <label>Upload Gambar (Minimal 5, Maksimal 50)</label>
    <input type="file" name="gambar[]" class="form-control" multiple>

    @if (isset($vila) && $vila->gambar)
        <div class="mt-3">
            @foreach (json_decode($vila->gambar) as $gambar)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $gambar) }}" width="100" class="mr-2">
                    <label class="ml-2">
                        <input type="checkbox" name="hapus_gambar[]" value="{{ $gambar }}"> Hapus Gambar Ini
                    </label>
                </div>
            @endforeach
        </div>
    @endif
</div>

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