@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📊 Data Bookingan Vila</h4>
        </div>

        <div class="card-body">
            {{-- Form Pencarian --}}
            <form action="{{ route('vila.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="🔍 Cari Nama atau Lokasi" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tabel Data Booking --}}
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Vila</th>
                            <th>Nama Vila</th>
                            <th class="text-center">Jumlah Booking</th>
                            <th class="text-center">Aksi</th>
                            <th>Uang Masuk Bulan Ini</th>
                            <th>Total Uang Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($villa as $index => $villas)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $villas['vila_id'] }}</td>
                                <td>{{ $villas['nama_vila'] }}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill badge-info py-2 px-3">
                                        {{ $villas['total_booking'] }} Booking
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('detailVilla', ['vila_id' => $villas['vila_id']]) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-calendar-plus"></i> Cek
                                    </a>
                                </td>
                                <td>
                                    Rp {{ number_format($villas['uang_masuk_bulan_ini'], 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format($villas['total_uang_masuk'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-light font-weight-bold">
                            <td colspan="6" class="text-right">Total Uang Masuk Bulan Ini:</td>
                            <td class="text-success font-weight-bold">
                                Rp {{ number_format($total_uang_masuk_bulan_ini, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-light font-weight-bold">
                            <td colspan="6" class="text-right">Total Uang Masuk (Mulai Bulan Ini & ke Depan):</td>
                            <td class="text-success font-weight-bold">
                                Rp {{ number_format($total_uang_masuk, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Rekap Bulanan --}}
            <h5 class="mt-5 mb-3">📅 Rekap Booking per Bulan</h5>
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>Bulan</th>
                            <th>Total Booking</th>
                            <th>Total Uang Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($monthly_summary as $bulan => $rekap)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($bulan . '-01')->translatedFormat('F Y') }}</td>
                                <td>{{ $rekap['total_booking'] }}</td>
                                <td>Rp {{ number_format($rekap['total_uang_masuk'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted">Belum ada data booking bulan ini ke depan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (jika ada) --}}
            {{-- <div class="mt-4">{{ $villa->links() }}</div> --}}
        </div>
    </div>
</div>
@endsection
