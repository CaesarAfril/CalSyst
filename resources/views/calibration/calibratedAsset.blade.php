@extends('templates.templates')
@section('style')
<style>
    .container {
        margin-top: 4rem;
    }

    .stat-card {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .stat-title {
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 10px 0;
    }

    .stat-footer {
        font-size: 0.9rem;
        color: #555;
        margin-top: 10px;
    }

    .shadow {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 10px 0px !important;
        width: fit-content !important;
    }
</style>
@endsection
@section('content')
{{-- <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-title">TOTAL ALAT TERKALIBRASI</div>
                    <div class="stat-value">{{ $calibratedCount }}</div>
<div class="stat-footer"></div>
</div>
</div>
</div> --}}

<h4>Aset dalam proses kalibrasi (status sampai Pembayaran, belum ada sertifikat): {{ $missingCalibrationCount }}</h4>



{{-- data alat terkalibrasi --}}
<div class="table-responsive text-nowrap mt-5 bg-white rounded-2 shadow">
    <h2 class="mt-5 mb-5 text-center">DATA ALAT TERKALIBRASI</h2>
    <hr class="mb-3" text-center>

    {{-- <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <form id="searchForm" method="GET" action="{{ route('late-calibration') }}" class=" d-flex align-items-center gap-2">
    <div class="input-group mb-3">
        <input type="search" class="form-control" placeholder="Ketik untuk mencari" name="search" value="{{ request('search') }}">
        <button class="btn btn-info" type="submit">Search</button>
        <a href="{{ route('late-calibration') }}" class="btn-reset btn btn-primary">Reset</a>
    </div>
    </form>
</div>
</div> --}}


<table class="table table-bordered text-center align-middle mx-2">
    <thead>
        <tr class="text-nowrap">
            <th>No.</th>
            <th>Nama Alat</th>
            <th>Serial Number</th>
            <th>Departemen</th>
            <th>ED Sertifikat</th>
            <th>Kalibrasi</th>
        </tr>

    </thead>
    <tbody>
        @forelse ($missingCalibrationAsset as $index => $asset)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $asset->category->category }}</td>
            <td>{{ $asset->series_number }}</td>
            <td>{{ $asset->department->department }}</td>
            <td>
                @if($asset->expired_date)
                <span style="color: red;">{{ \Carbon\Carbon::parse($asset->expired_date)->format('d-m-y') }}</span>
                @else
                <span style="color: gray;">N/A</span>
                @endif
            </td>
            <td>{{ $asset->category->calibration }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="text-center">Tidak ada data.</td>
        </tr>
        @endforelse

    </tbody>
</table>
{{-- <div class="d-flex justify-content-end mt-3">
        {{ $expiredAssets->links('pagination::bootstrap-5') }}
</div> --}}
</div>
</div>
@endsection
@section('script')
<script>
    // Optional: You can implement JavaScript to handle dynamic form population, if necessary.
</script>
@endsection