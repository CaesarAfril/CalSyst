@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            Data Verifikasi Alat Ukur Temperatur
        </h5>

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                        <th style="color: #fff">No.</th>
                        <th style="color: #fff">Tanggal</th>
                        <th style="color: #fff">Alat</th>
                        <th style="color: #fff">Departemen</th>
                        <th style="color: #fff">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{ $report->date->format('d-m-Y') }}</td>
                        <td>{{$report->asset->merk}} {{$report->asset->type}} {{$report->asset->series_number}}</td>
                        <td>{{$report->asset->department->department}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" onclick="printPDF('{{ route('Internal_calibration.PrintPDFdisplay', $report->uuid) }}')">
                                Cetak PDF
                            </button>

                            <script>
                                function printPDF(pdfUrl) {
                                    var win = window.open(pdfUrl, '_blank');
                                }
                            </script>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // Optional: You can implement JavaScript to handle dynamic form population, if necessary.
</script>
@endsection