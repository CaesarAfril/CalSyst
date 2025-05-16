@extends('templates.templates')

@section('style')
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y p-0" style="border-radius: 16px;">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            Fryer Marel
            <a href="{{ route('report.validation.addDataFryerMarel') }}" class="btn btn-primary">
                +
            </a>
        </h5>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                        <th style="color: #fff">No.</th>
                        <th style="color: #fff">Tanggal pengujian</th>
                        <th style="color: #fff">Nama Produk</th>
                        <th style="color: #fff">Nama Mesin</th>
                        <th style="color: #fff">Merek</th>
                        <th style="color: #fff">Tipe</th>
                        <th style="color: #fff">Freon</th>
                        <th style="color: #fff">Kapasitas</th>
                        <th style="color: #fff">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($dataABF as $item) --}}
                        <tr>
                            <th>0</th>
                            <th>0</th>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('report.fryerMarel.print') }}" class="btn btn-primary btn-sm me-2" target="_blank">
                                    Cetak PDF
                                </a>
                                <form action="" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm me-2" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    {{-- @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data</td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection