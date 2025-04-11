@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Data Verifikasi Alat Ukur Temperatur
        </h5>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Alat</th>
                        <th>Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$report->date}}</td>
                        <td>{{$report->asset->merk}} {{$report->asset->type}} {{$report->asset->series_number}}</td>
                        <td>{{$report->asset->department->department}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" onclick="printPDF('{{ route('Internal_calibration.PrintPDFdisplay', $report->uuid) }}')">
                                Cetak
                            </button>

                            <script>
                                function printPDF(pdfUrl) {
                                    var win = window.open(pdfUrl, '_blank');
                                    win.onload = function() {
                                        win.print();
                                    };
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