@extends('layout.master')

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
        <h1 class="h3 mb-0 text-gray-800">📊 Data Bookingan Vila</h1>
    </div>

    <!-- Card Utama -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">📋 Daftar Bookingan</h6>
        </div>

        <div class="card-body">

            <!-- Form Pencarian -->
            <form action="{{ route('vila.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="🔍 Cari Nama atau Lokasi Vila..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tabel Booking -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Vila</th>
                            <th>Nama Vila</th>
                            <th>Jumlah Booking</th>
                            <th>Aksi</th>
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
                                <td>
                                    <span class="badge badge-info p-2">{{ $villas['total_booking'] }} Booking</span>
                                </td>
                                <td>
                                    <a href="{{ route('detailVilla', ['vila_id' => $villas['vila_id']]) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-calendar-plus"></i> Lihat Detail
                                    </a>
                                </td>
                                <td class="text-success font-weight-bold">
                                    Rp {{ number_format($villas['uang_masuk_bulan_ini'], 0, ',', '.') }}
                                </td>
                                <td class="text-primary font-weight-bold">
                                    Rp {{ number_format($villas['total_uang_masuk'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="font-weight-bold bg-light">
                        <tr>
                            <td colspan="6" class="text-right text-dark">🗓️ Total Uang Masuk Bulan Ini:</td>
                            <td class="text-success">
                                Rp {{ number_format($total_uang_masuk_bulan_ini, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-right text-dark">📦 Total Uang Masuk (Bulan Ini & Seterusnya):</td>
                            <td class="text-primary">
                                Rp {{ number_format($total_uang_masuk, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Rekap Per Bulan -->
            <h5 class="mt-5 mb-3">📅 Rekap Booking per Bulan</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
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
                                <td><span class="badge badge-secondary p-2">{{ $rekap['total_booking'] }}</span></td>
                                <td class="text-primary font-weight-bold">Rp {{ number_format($rekap['total_uang_masuk'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted">Belum ada data booking dari bulan ini ke depan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection
