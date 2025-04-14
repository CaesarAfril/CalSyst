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
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
  }

  th, td {
    padding: 10px 0px !important;
    width: fit-content !important;
  }
</style>
@endsection
@section('content')
{{-- total section --}}
<div class="container width-full">
    <div class="row g-3">
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-title">TOTAL MESIN DAN PERALATAN</div>
          <div class="stat-value">{{ $totalAssets }}</div>
          <div class="stat-footer"></div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-title">TOTAL ALAT SUDAH KALIBRASI</div>
          <div class="stat-value">27%</div>
          <div class="stat-footer"></div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-title">TOTAL ALAT ON TRACK KALIBRASI</div>
          <div class="stat-value">95%</div>
          <div class="stat-footer"></div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat-card">
          <div class="stat-title">TOTAL ALAT KALIBRASI</div>
          <div class="stat-value">100%</div>
          <div class="stat-footer"></div>
        </div>
      </div>
    </div>
</div>

{{-- data alat kalibrasi --}}
<div class="table-responsive text-nowrap mt-5 bg-white rounded-2 shadow">
    <h2 class="mt-5 mb-5 text-center">DATA ALAT PROSES KALIBRASI</h2>
    <hr class="mb-5" text-center>
    <table class="table table-bordered text-center align-middle mx-2">
        <thead>
            <tr class="text-nowrap">
                <th>No.</th>
                <th>Nama Alat</th>
                <th>Serial Number</th>
                <th>Departemen</th>
                <th>ED Sertifikat</th>
                <th>Kalibrasi</th>
                <th>Progress</th>
                <th>Status</th>
            </tr>
        
        </thead>
        <tbody>
            <tr>
                <th>1</th>
                <td>Timbangan</td>
                <td>C117648682</td>
                <td>Sausage</td>
                <td>23</td>
                <td>Kalibrasi</td>
                <td>Progress</td>
                <td>Status</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- data alat mendekati ED --}}
<div class="table-responsive text-nowrap mt-5 bg-white rounded-2 shadow">
    <h2 class="mt-5 mb-5 text-center">DATA ALAT MENDEKATI ED KALIBRASI</h2>
    <hr class="mb-5" text-center>
    <table class="table table-bordered text-center align-middle mx-2">
        <thead>
            <tr class="text-nowrap">
                <th>No.</th>
                <th>Nama Alat</th>
                <th>Serial Number</th>
                <th>Departemen</th>
                <th>ED Sertifikat</th>
                <th>Kalibrasi</th>
                <th>Progress</th>
                <th>Status</th>
            </tr>
        
        </thead>
        <tbody>
        @forelse ($assets as $index => $asset)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $asset->category->category }}</td>
            <td>{{ $asset->series_number }}</td>
            <td>{{ $asset->department->department }}</td>
            <td>
                @if($asset->category->calibration === 'External' && $asset->latest_external_calibration)
                    @php
                        $date = \Carbon\Carbon::parse($asset->latest_external_calibration->expired_date);
                        $daysLeft = now()->diffInDays($date, false);
                    @endphp
                    <span style="color: red;">{{ $date->format('d-m-y') }}</span>

                @elseif($asset->category->calibration === 'Internal' && $asset->category->category === 'Thermometer' && $asset->latest_temp_calibration)
                    @php
                        $date = \Carbon\Carbon::parse($asset->latest_temp_calibration->expired_date);
                        $daysLeft = now()->diffInDays($date, false);
                    @endphp
                    <span style="color: red;">{{ $date->format('d-m-y') }}</span>

                @elseif($asset->category->category === 'Display Suhu' && $asset->latest_display_calibration)
                    @php
                        $date = \Carbon\Carbon::parse($asset->latest_display_calibration->expired_date);
                        $daysLeft = now()->diffInDays($date, false);
                    @endphp
                    <span style="color: red;">{{ $date->format('d-m-y') }}</span>

                @else
                    <span style="color: gray;">N/A</span>
                @endif
            </td>
            <td>{{ $asset->category->calibration }}</td>
            <td>p</td>
            <td>p</td>
        </tr>
@empty
<tr>
    <td colspan="10" class="text-center">Tidak ada data.</td>
</tr>
@endforelse

        </tbody>

    </table>

  </div>
@endsection
@section('script')
@endsection

