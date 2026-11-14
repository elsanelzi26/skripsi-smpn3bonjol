@extends('layouts.master')
@section('title', 'Rekap Perangkingan')

@section('content')
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-title">
                        <h4>Filter Rekap Perangkingan</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('penilaian.rekap-perangkingan') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Kelas</label>
                                    <select class="form-control" name="id_kelas" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($data_kelas as $k)
                                            <option value="{{ $k->id_kelas }}"
                                                {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Semester / TA</label>
                                    <select class="form-control" name="id_tahun_ajaran" required>
                                        <option value="">-- Pilih Semester --</option>
                                        @foreach ($data_tahun_ajaran as $t)
                                            <option value="{{ $t->id_tahun_ajaran }}"
                                                {{ request('id_tahun_ajaran') == $t->id_tahun_ajaran ? 'selected' : '' }}>
                                                {{ $t->teks_tahun_ajaran }} - Sem {{ $t->semester }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><i
                                            class="ti-search"></i> Tampilkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if (!empty($rekap_nilai))
                    <div class="card mt-4">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <h4>Data Rekap Ranking Siswa</h4>
                            <a href="{{ route('penilaian.rekapPerangkinganExportPdf', request()->all()) }}" class="btn btn-danger btn-sm">
                                <i class="ti-printer"></i> Cetak / Export PDF
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center table-sm">
                                    <thead>
                                        <tr class="bg-light">
                                            <th style="width: 60px;">No</th>
                                            <th>NISN</th>
                                            <th class="text-left">Nama Siswa</th>

                                            @foreach ($data_mapel as $mapel)
                                                <th>{{ $mapel->nama_mapel }}</th>
                                            @endforeach

                                            <th>Rata-rata</th>
                                            <th>Ranking</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rekap_nilai as $index => $row)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $row['nisn'] }}</td>
                                                <td class="text-left"><strong>{{ $row['nama_siswa'] }}</strong></td>

                                                @foreach ($data_mapel as $mapel)
                                                    <td>{{ $row['nilai_mapel'][$mapel->id_mapel] ?? 0 }}</td>
                                                @endforeach

                                                <td class="table-warning"><strong>{{ $row['rata_rata'] }}</strong></td>

                                                <td>
                                                    @if ($index + 1 == 1)
                                                        {{-- <span class="badge badge-warning">🥇 Rank 1</span> --}}
                                                        <span class="badge badge-warning">1</span>
                                                    @elseif($index + 1 == 2)
                                                        {{-- <span class="badge badge-secondary">🥈 Rank 2</span> --}}
                                                        <span class="badge badge-secondary">2</span>
                                                    @elseif($index + 1 == 3)
                                                        {{-- <span class="badge badge-danger">🥉 Rank 3</span> --}}
                                                        <span class="badge badge-danger">3</span>
                                                    @else
                                                        <span
                                                            class="badge badge-light text-dark">{{ $index + 1 }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
