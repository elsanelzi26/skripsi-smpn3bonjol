@extends('layouts.master')
@section('title', 'Rekap Penilaian')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            
            <div class="card">
                <div class="card-title">
                    <h4>Filter Rekap Penilaian</h4>
                </div>
                <div class="card-body">
                    <!-- Filter menggunakan method GET agar nilainya menetap saat direfresh -->
                    <form method="GET" action="{{ route('penilaian.rekap') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Kelas</label>
                                <select class="form-control" name="id_kelas" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($data_kelas as $k)
                                        <option value="{{ $k->id_kelas }}" {{ $request->id_kelas == $k->id_kelas ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Mata Pelajaran</label>
                                <select class="form-control" name="id_mapel" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach($data_mapel as $m)
                                        <option value="{{ $m->id_mapel }}" {{ $request->id_mapel == $m->id_mapel ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Semester / TA</label>
                                <select class="form-control" name="id_tahun_ajaran" required>
                                    <option value="">-- Pilih Semester --</option>
                                    @foreach($data_tahun_ajaran as $t)
                                        <option value="{{ $t->id_tahun_ajaran }}" {{ $request->id_tahun_ajaran == $t->id_tahun_ajaran ? 'selected' : '' }}>
                                            {{ $t->teks_tahun_ajaran }} - Sem {{ $t->semester }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="ti-search"></i> Tampilkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(!empty($rekap_nilai))
            <div class="card mt-4">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <h4>Data Rekap Nilai Siswa</h4>
                    <!-- Tombol cetak mengirimkan parameter filter yang sama ke route PDF -->
                    <a href="{{ route('penilaian.exportPdf', request()->all()) }}" class="btn btn-danger btn-sm">
                        <i class="ti-printer"></i> Cetak / Export PDF
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="text-left">Nama Siswa</th>
                                    <th>NISN</th>
                                    <th>Tugas</th>
                                    <th>UH</th>
                                    <th>UTS</th>
                                    <th>UAS</th>
                                    <th>Rata-rata</th>
                                    <th>Huruf</th>
                                    <th>Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekap_nilai as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-left">{{ $row['nama_siswa'] }}</td>
                                    <td>{{ $row['nisn'] }}</td>
                                    <td>{{ $row['nilai_tugas'] }}</td>
                                    <td>{{ $row['nilai_uh'] }}</td>
                                    <td>{{ $row['nilai_uts'] }}</td>
                                    <td>{{ $row['nilai_uas'] }}</td>
                                    <td class="table-warning"><strong>{{ $row['rata_rata'] }}</strong></td>
                                    <td><span class="badge badge-primary">{{ $row['huruf'] }}</span></td>
                                    <td>{{ $row['predikat'] }}</td>
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