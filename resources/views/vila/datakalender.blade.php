@extends('layout.master')

@section('content')
<div class="container-fluid mt-4">

    <!-- Heading -->
    <h1 class="h3 mb-4 text-gray-800">📋 Data Bookingan Vila</h1>

    <!-- Card: Daftar Bookingan -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary">
            <h6 class="m-0 font-weight-bold text-white">📌 Daftar Bookingan</h6>
        </div>
        <div class="card-body">

            <!-- Form Pencarian -->
            <form action="{{ route('vila.index') }}" method="GET" class="form-inline mb-4">
                <div class="input-group w-50">
                    <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="🔍 Cari Nama atau Lokasi" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            <!-- Table Booking -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ID Vila</th>
                            <th>Nama Vila</th>
                            <th>Jumlah Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($villa as $index => $v)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $v['vila_id'] }}</td>
                                <td>{{ $v['nama_vila'] }}</td>
                                <td>
                                    <span class="badge badge-info px-3 py-2">{{ $v['total_booking'] }} Booking</span>
                                </td>
                                <td>
                                    <a href="{{ route('vila.tambahTanggal', ['vila_id' => $v['vila_id']]) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-calendar-plus"></i> Cek
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Card: Tamu Booking Hari Ini -->
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white py-3">
            <h6 class="m-0 font-weight-bold">📅 Daftar Tamu Booking Hari Ini</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No Booking</th>
                        <th>Nama Tamu</th>
                        <th>Nama Villa</th>
                        <th>Check-in</th>
                        <th>Total</th>
                        <th>Uang Masuk</th>
                        <th>Sisa</th>
                        <th>Pelunasan</th>
                        <th>Catatan</th>
                        <th>No HP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($villa as $v)
                        @foreach($v['today_bookings'] as $b)
                            <tr>
                                <td>{{ $b['no'] }}</td>
                                <td>{{ $b['nama_tamu'] }}</td>
                                <td>{{ $v['nama_vila'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($b['check_in'])->translatedFormat('d F Y') }}</td>
                                <td>Rp {{ number_format($b['total'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($b['uang_masuk'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($b['sisa'], 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($b['pelunasan'])->translatedFormat('d F Y') }}</td>
                                <td>{{ $b['catatan'] }}</td>
                                <td>{{ $b['no_hp'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card: Pelunasan Hari Ini -->
    <div class="card shadow mb-4">
        <div class="card-header bg-warning text-white py-3">
            <h6 class="m-0 font-weight-bold">💰 Daftar Tamu Pelunasan Hari Ini</h6>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>No Booking</th>
                        <th>Nama Tamu</th>
                        <th>Nama Villa</th>
                        <th>Check-in</th>
                        <th>Sisa</th>
                        <th>Pelunasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($villa as $v)
                        @foreach($v['unpaid_pelunasan'] as $p)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $p['no'] }}</td>
                                <td>{{ $p['nama_tamu'] }}</td>
                                <td>{{ $v['nama_vila'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($p['check_in'])->translatedFormat('d F Y') }}</td>
                                <td>Rp {{ number_format($p['sisa'], 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($p['pelunasan'])->translatedFormat('d F Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('vila.updateStatus', $p['id']) }}" class="d-flex align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-control form-control-sm mr-2" onchange="this.form.submit()">                                                
                                            <option value="Belum Lunas" {{ $p['status'] == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                            <option value="Cicil" disabled {{ $p['status'] == 'Cicil' ? 'selected' : '' }}>Cicil</option>
                                            <option value="Lunas" {{ $p['status'] == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Batal" disabled {{ $p['status'] == 'Batal' ? 'selected' : '' }}>Batal</option>
                                        </select>

                                        @if($p['status'] !== 'Batal')
                                        <button type="button" class="btn btn-sm btn-secondary mr-1" data-toggle="modal" data-target="#cicilModal{{ $p['id'] }}">
                                            <i class="fas fa-wallet"></i>
                                        </button>
                                        @endif

                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#batalModal{{ $p['id'] }}">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </form>

                                    <!-- Modal Cicil -->
                                    @include('vila.modal_cicil', ['p' => $p])

                                    <!-- Modal Batal -->
                                    @include('vila.modal_batal', ['p' => $p])
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
