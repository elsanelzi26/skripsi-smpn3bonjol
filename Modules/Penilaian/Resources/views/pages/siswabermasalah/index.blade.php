@extends('layouts.master')
@section('title', 'Rekap Siswa Bermasalah')

@section('content')
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-title">
                        <h4>Filter Analisis Siswa Bermasalah</h4>
                    </div>
                    <div class="card-body mt-2">
                        <form method="GET" action="{{ route('siswabermasalah.index') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="font-weight-bold">Pilih Kelas</label>
                                    <select class="form-control" name="id_kelas" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($data_kelas as $k)
                                            <option value="{{ $k->id_kelas }}"
                                                {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="font-weight-bold">Dari Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_mulai"
                                        value="{{ request('tanggal_mulai') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="font-weight-bold">Sampai Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal_selesai"
                                        value="{{ request('tanggal_selesai') }}" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block"><i
                                            class="ti-search"></i> Analisis</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if (request()->filled('id_kelas'))
                    <div class="card mt-4">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <h4>Hasil Rekap Siswa di Luar Capaian & Batas Toleransi</h4>
                            <a href="{{ route('siswabermasalah.cetakPdf', request()->all()) }}"
                                class="btn btn-danger btn-sm shadow">
                                <i class="ti-printer"></i> Cetak PDF Laporan
                            </a>
                        </div>
                        <div class="card-body mt-3">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center">
                                            <th width="5%">No</th>
                                            <th>Nama Siswa</th>
                                            <th width="12%">NISN</th>
                                            <th>Indikator Catatan Masalah (Absen / Akademik)</th>
                                            <th width="15%">Status BK</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rekap_masalah as $index => $row)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td><strong>{{ $row['nama_siswa'] }}</strong></td>
                                                <td class="text-center">{{ $row['nisn'] }}</td>
                                                <td>
                                                    <ul class="mb-0 pl-3">
                                                        @foreach ($row['alasan'] as $alasan)
                                                            <li class="text-danger font-weight-bold">{{ $alasan }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td class="text-center">
                                                    @if ($row['status_bk'] == '1')
                                                        <span class="badge badge-danger"
                                                            style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 4px;">Belum Diproses</span>
                                                    @elseif($row['status_bk'] == '2')
                                                        <span class="badge badge-warning"
                                                            style="background-color: #ffc107; color: black; padding: 5px 10px; border-radius: 4px;">Dipanggil BK</span>
                                                    @else
                                                        <span class="badge badge-success"
                                                            style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 4px;">Selesai</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-info btn-xs text-white"
                                                        data-toggle="modal"
                                                        data-target="#modalTindakLanjut{{ $row['id_siswa'] }}"
                                                        title="Tindak Lanjut">
                                                        <i class="ti-pencil-alt"></i> Tindakan
                                                    </button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="modalTindakLanjut{{ $row['id_siswa'] }}"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title">Tindak Lanjut Masalah:
                                                                <strong>{{ $row['nama_siswa'] }}</strong></h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('siswabermasalah.updateStatus') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id_siswa"
                                                                value="{{ $row['id_siswa'] }}">
                                                            <input type="hidden" name="tanggal_analisis"
                                                                value="{{ date('Y-m-d') }}">

                                                            <div class="modal-body text-left">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold">Ubah Status Penanganan</label>
                                                                    <select class="form-control" name="status_bk" required>
                                                                        <option value="1"
                                                                            {{ $row['status_bk'] == '1' ? 'selected' : '' }}>
                                                                            Belum Diproses</option>
                                                                        <option value="2"
                                                                            {{ $row['status_bk'] == '2' ? 'selected' : '' }}>
                                                                            Dipanggil BK</option>
                                                                        <option value="3"
                                                                            {{ $row['status_bk'] == '3' ? 'selected' : '' }}>
                                                                            Selesai</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group mt-2">
                                                                    <label class="font-weight-bold">Catatan Hasil Konseling / Tindakan</label>
                                                                    <textarea class="form-control" name="catatan_tindak_lanjut" rows="4"
                                                                        placeholder="Ketik hasil pemanggilan atau bimbingan di sini...">{{ $row['catatan_tindak_lanjut'] }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm">Simpan Perubahan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-success font-weight-bold">
                                                    Luar Biasa! Tidak ditemukan siswa bermasalah pada kelas dan periode ini.
                                                </td>
                                            </tr>
                                        @endforelse
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