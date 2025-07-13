@extends('layout.master')

@section('content')
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Bookingan Vila</h3>
        </div>

        <div class="card-body">
            {{-- Form Pencarian --}}
            <form action="{{ route('vila.index') }}" method="GET" class="form-inline mb-3">
                <div class="input-group w-50">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama atau Lokasi" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            {{-- Tabel --}}
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>ID Vila</th>
                        <th>Nama Vila</th>
                        <th>Jumlah Booking</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($villa as $index => $villas)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $villas['vila_id'] }}</td>
                            <td>{{ $villas['nama_vila'] }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $villas['total_booking'] }} Booking
                                </span>
                            </td>


                            <td>
                                <a href="{{ route('vila.tambahTanggal', ['vila_id' => $villas['vila_id']]) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-calendar-plus"></i> CEK
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card mt-4">
                <div class="card-header bg-info">
                    <h3 class="card-title">Daftar Tamu Booking Hari Ini</h3>
                </div>
                <div class="card-body">
                    @foreach($villa as $v)
                        @if(count($v['today_bookings']))
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered">
                                    <thead>
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
                                        @foreach($v['today_bookings'] as $i => $b)
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
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="card mt-4">
            <div class="card-header bg-warning">
                <h3 class="card-title">Daftar Tamu Pelunasan Hari Ini</h3>
            </div>
            <div class="card-body">
            @foreach($villa as $v)
                @if(count($v['unpaid_pelunasan']))
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
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
                                @foreach($v['unpaid_pelunasan'] as $i => $p)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $p['no'] }}</td>
                                        <td>{{ $p['nama_tamu'] }}</td>
                                        <td>{{ $v['nama_vila'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p['check_in'])->translatedFormat('d F Y') }}</td>
                                        <td>Rp {{ number_format($p['sisa'], 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p['pelunasan'])->translatedFormat('d F Y') }}</td>
                                        <td>
                                            <form action="{{ route('vila.updateStatus', $p['id']) }}" method="POST" class="d-flex align-items-center">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                                                    <option value="Belum Lunas" {{ $p['status'] == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                                    <option value="Cicil" {{ $p['status'] == 'Cicil' ? 'selected' : '' }}>Cicil</option>
                                                    <option value="Lunas" {{ $p['status'] == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                                </select>

                                                <!-- Tombol Modal Cicil -->
                                                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#cicilModal{{ $p['id'] }}">
                                                    <i class="fas fa-wallet"></i>
                                                </button>
                                            </form>

                                            <!-- Modal Cicil -->
                                            <div class="modal fade" id="cicilModal{{ $p['id'] }}" tabindex="-1" role="dialog" aria-labelledby="cicilModalLabel{{ $p['id'] }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form action="{{ route('vila.cicil', $p['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Tambah Cicilan - {{ $p['nama_tamu'] }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Jumlah Cicilan</label>
                                                                    <input type="number" name="jumlah" class="form-control" min="1" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
            </div>
        </div>
            {{-- Pagination --}}
            {{-- Tambahkan jika pakai pagination --}}
            {{-- {{ $villa->links() }} --}}
        </div>
    </div>
</div>
@endsection
