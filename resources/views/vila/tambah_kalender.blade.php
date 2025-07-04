@extends('layout.master')

@section('content')
<div class="container-fluid mt-3">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Tanggal Booking</h3>
        </div>
        <form action="{{ route('vila.storeTanggal') }}" method="POST">
            @csrf
            <input type="hidden" name="vila_id" value="{{ $villa->vila_id }}">

            <div class="card-body">
                <div class="form-group">
                    <label for="check_in_date">Tanggal Check-in</label>
                    <input id="check_in_date" name="check_in_date" type="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="check_out_date">Tanggal Check-out</label>
                    <input id="check_out_date" name="check_out_date" type="date" class="form-control" required>
                </div>
            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Daftar Booking --}}
    <div class="card mt-4">
        <div class="card-header bg-info">
            <h3 class="card-title">Daftar Tanggal Sudah Dipesan</h3>
        </div>

        <div class="card-body">
            @if($reservasi->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservasi as $index => $r)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->check_in_date)->translatedFormat('d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->check_out_date)->translatedFormat('d F Y') }}</td>
                                    <td>
                                        <form action="{{ route('vila.destroyTanggal', $r->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
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
            @else
                <p><em>Belum ada tanggal yang dipesan.</em></p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkInInput = document.getElementById('check_in_date');
        const checkOutInput = document.getElementById('check_out_date');

        checkInInput.addEventListener('change', function () {
            if (checkInInput.value) {
                const checkInDate = new Date(checkInInput.value);
                checkInDate.setDate(checkInDate.getDate() + 1);

                const year = checkInDate.getFullYear();
                const month = String(checkInDate.getMonth() + 1).padStart(2, '0');
                const day = String(checkInDate.getDate()).padStart(2, '0');

                checkOutInput.value = `${year}-${month}-${day}`;
            }
        });
    });
</script>
@endpush
