@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">
    <!-- Card Tambah Tanggal -->
    <div class="card shadow">
        <div class="card-header bg-primary py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-calendar-plus mr-2"></i>Tambah Tanggal Booking
            </h6>
        </div>
        <form action="{{ route('vila.storeTanggalOnly') }}" method="POST">
            @csrf
            <input type="hidden" name="vila_id" value="{{ $villa->vila_id }}">
            <div class="card-body">
                <div id="tanggal-container">
                    <div class="form-row tanggal-item mb-2">
                        <div class="col-md-4">
                            <label>Check-in</label>
                            <input name="check_in_date[]" type="date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label>Check-out</label>
                            <input name="check_out_date[]" type="date" class="form-control" required>
                        </div>
                        <div class="col-md-0 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-block remove-tanggal py-2">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-tanggal" class="btn btn-outline-primary btn-sm mt-2">
                    <i class="fas fa-plus"></i> Tambah Tanggal
                </button>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-save"></i> Simpan Semua
                </button>
            </div>
        </form>
    </div>

    @if ($reservasi->count() > 0)
    <!-- Card Daftar Tanggal Booking -->
    <div class="card shadow mt-4">
        <div class="card-header bg-secondary py-3">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-calendar-alt mr-2"></i>Daftar Tanggal yang Sudah Dibooking
            </h6>
        </div>
        <div class="card-body table-responsive">
            @php
                $grouped = $reservasi->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->check_in_date)->format('F Y');
                });
            @endphp
            <table class="table table-bordered table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grouped as $month => $items)
                        <tr style="background-color: #f1f3f5;">
                            <td colspan="3" class="font-weight-bold text-primary text-left pl-3">
                                {{ \Carbon\Carbon::parse($items[0]->check_in_date)->translatedFormat('F Y') }}
                            </td>
                        </tr>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->check_in_date)->translatedFormat('j F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->check_out_date)->translatedFormat('j F Y') }}</td>
                            <td>
                                <form action="{{ route('vila.destroyTanggalOnly', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tanggal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('tanggal-container');
    const addBtn = document.getElementById('add-tanggal');

    function autoSetCheckout(input) {
        input.addEventListener('change', function () {
            const checkInDate = new Date(this.value);
            if (!isNaN(checkInDate)) {
                const checkOutDate = new Date(checkInDate);
                checkOutDate.setDate(checkOutDate.getDate() + 1);
                const formatted = checkOutDate.toISOString().split('T')[0];

                const checkoutInput = this.closest('.tanggal-item').querySelector('input[name="check_out_date[]"]');
                if (checkoutInput) {
                    checkoutInput.value = formatted;
                }
            }
        });
    }

    // Set event untuk pertama
    container.querySelectorAll('input[name="check_in_date[]"]').forEach(autoSetCheckout);

    // Tambah field baru
    addBtn.addEventListener('click', function () {
        const html = `
        <div class="form-row tanggal-item mb-2">
            <div class="col-md-4">
                <label>Check-in</label>
                <input name="check_in_date[]" type="date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Check-out</label>
                <input name="check_out_date[]" type="date" class="form-control" required>
            </div>
            <div class="col-md-0 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-block remove-tanggal py-2">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);

        const newCheckIn = container.querySelectorAll('input[name="check_in_date[]"]');
        autoSetCheckout(newCheckIn[newCheckIn.length - 1]);
    });

    // Hapus field tanggal
    container.addEventListener('click', function (e) {
        if (e.target.closest('.remove-tanggal')) {
            e.target.closest('.tanggal-item').remove();
        }
    });
});
</script>
@endpush
