@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            Data Verifikasi Alat Ukur Temperatur
            <a href="{{ route('report.addDataTemperature') }}" class="btn btn-primary">
                +
            </a>
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
                        <td>{{ \Carbon\Carbon::parse($report->date)->format('d-m-Y') }}</td>
                        <td>{{$report->asset->merk}} {{$report->asset->type}} {{$report->asset->series_number}}</td>
                        <td>{{$report->asset->department->department}}</td>
                        <td>
                            <a href="{{route('report.exportDataTemperature', $report->uuid)}}" class="btn btn-warning btn-sm">Export Excel</a>

                            <button type="button" class="btn btn-primary btn-sm" onclick="printPDF('{{ route('Internal_calibration.PrintPDFTemperature', $report->uuid) }}')">
                                Cetak PDF
                            </button>

                            <script>
                                function printPDF(pdfUrl) {
                                    window.open(pdfUrl, '_blank');
                                }
                            </script>

                            <form action="{{ route('temperature.approve', $report->uuid) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" onclick="return confirm('Approve data ini?')" class="btn btn-success btn-sm">
                                    Approve
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    document.getElementById('approveBtn').addEventListener('click', function() {
    document.getElementById('approveModal').style.display = 'block';
});

document.getElementById('cancelBtn').addEventListener('click', function() {
    document.getElementById('approveModal').style.display = 'none';
});

document.getElementById('confirmBtn').addEventListener('click', function() {
    document.getElementById('approveForm').submit();
    document.getElementById('approveModal').style.display = 'none';
});
</script>
@endsection