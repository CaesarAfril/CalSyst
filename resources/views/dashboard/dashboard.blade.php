@extends('templates.templates')

<head>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

@section('style')
<style>
  .container {
        margin-top: 4rem;
  }
  .stat-card-custom {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  padding: 24px 36px;
  transition: all 0.3s ease;
  text-align: left;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 200px;
  position: relative;
  overflow: hidden;
}

.stat-card-custom:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.stat-card-custom:hover .stat-title {
  color: #C14600; /* Misal biru Bootstrap */
}

.stat-card-custom:hover .stat-value {
  color: #C14600;
}

.stat-title {
  font-size: 0.9rem;
  color: #566A7F;
  font-weight: 600;
  text-transform: uppercase;
  width: 80%; /* atau bisa 80% kalau ingin lebih sempit */
  margin-bottom: .5rem;
  text-transform: uppercase;
  word-wrap: break-word;
  z-index: 99;
}

.stat-value {
  font-size: 2.2rem;
  margin-left: 1rem;
  font-weight: bold;
  color: #343a40;
  z-index: 99;
}

.image-card {
  width: 90%;
  position: absolute;
  top: -4.5rem;
  right: -5rem;
}

</style>
@endsection
@section('content')
{{-- total section --}}
<div class="container width-full mx-0 px-0 mt-4">
  <div class="row g-3">
    <div class="col-md-3">
      <div class="stat-card-custom">
        <img src="{{ url('/image/asset.svg') }}" alt="asset" class="image-card">
        <div class="stat-title">TOTAL MESIN DAN PERALATAN</div>
        <div class="stat-value">{{ $totalAssets }}</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card-custom">
        <img src="{{ url('/image/done.svg') }}" alt="asset" class="image-card">
        <div class="stat-title">TOTAL ALAT SUDAH KALIBRASI</div>
        <div class="stat-value">{{ $calibratedCount }}</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card-custom">
        <img src="{{ url('/image/ontrack.svg') }}" alt="asset" class="image-card">
        <div class="stat-title">TOTAL ALAT ON TRACK KALIBRASI</div>
        <div class="stat-value">{{ $onTrackCount }}</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stat-card-custom">
        <img src="{{ url('/image/ed.svg') }}" alt="asset" class="image-card">
        <div class="stat-title">TOTAL ALAT MENDEKATI ED KALIBRASI</div>
        <div class="stat-value">{{ $approachingEDCount }}</div>
      </div>
    </div>
  </div>
</div>

{{-- data alat kalibrasi --}}
<div class="table-responsive text-nowrap mt-5 bg-white rounded-2 shadow px-2">
    <h3 class="text-center mt-4 mb-4">DATA ALAT PROSES KALIBRASI</h3>
    <hr class="mb-4" text-center>
    <table class="table table-bordered text-center align-middle">
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
                <th>Reminder</th>
            </tr>
        
        </thead>
        <tbody>
          @forelse ($onTrackAsset as $index => $onTrackAssets)
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $onTrackAssets->asset->category->category }}</td>
                <td>{{ $onTrackAssets->asset->series_number }}</td>
                <td>{{ $onTrackAssets->asset->department->department }}</td>
                <td>{{ \Carbon\Carbon::parse($onTrackAssets->asset->expired_date)->format('d-m-Y') }}</td>
                <td>{{ $onTrackAssets->asset->category->calibration }}</td>
                <td> {{ $onTrackAssets->asset->latest_external_calibration->progress_status ?? '-' }}</td>
                <td>{!! $onTrackAssets->status_message !!}</td>
                <td>{!! $onTrackAssets->asset->reminder_status !!}</td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Tidak ada data.</td>
            </tr>
          @endforelse
        </tbody>
    </table>
</div>

{{-- data alat mendekati ED --}}
<div class="table-responsive text-nowrap mt-5 bg-white rounded-2 shadow px-2">
    <h3 class="mt-4 mb-4 text-center">DATA ALAT MENDEKATI ED KALIBRASI</h3>
    <hr class="mb-4" text-center>
    <table class="table table-bordered text-center align-middle">
        <thead>
            <tr class="text-nowrap">
                <th>No.</th>
                <th>Nama Alat</th>
                <th>Serial Number</th>
                <th>Departemen</th>
                <th>ED Sertifikat</th>
                <th>
                  @php
                      $currentSort = request()->get('sort');
                      $currentDirection = request()->get('direction', 'asc');
                      $column = 'category.calibration';
                      $isSorted = $currentSort === $column;
                      $nextDirection = $isSorted && $currentDirection === 'asc' ? 'desc' : 'asc';
                  @endphp
              
                  <a href="{{ route('dashboard', [
                          'sort' => $column, 
                          'direction' => $nextDirection
                      ]) }}" class="d-flex align-items-center justify-content-center gap-1 text-decoration-none" style="color: #566A7F;">
                      <span>KALIBRASI</span>
                      @if ($isSorted)
                          @if ($currentDirection === 'asc')
                              <i class='bx bx-sort-a-z bx-xs text-primary'></i>
                          @else
                              <i class='bx bx-sort-z-a bx-xs text-primary'></i>
                          @endif
                      @else
                          <i class='bx bx-sort-a-z bx-xs'></i>
                      @endif
                  </a>
              </th>
              <th>reminder</th>
            </tr>
        
        </thead>
        <tbody>
        @forelse ($assets as $index => $asset)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $asset->category->category }}</td>
            <td>{{ $asset->series_number }}</td>
            <td>{{ $asset->department->department }}</td>
            <td>
              @if($asset->expired_date)
                  <span style="color: red;">{{ \Carbon\Carbon::parse($asset->expired_date)->format('d-m-Y') }}</span>
              @else
                  <span style="color: gray;">N/A</span>
              @endif
          </td>
            <td>{{ $asset->category->calibration }}</td>
            <td>{!! $asset->reminder_status !!}</td>
        </tr>
@empty
<tr>
    <td colspan="10" class="text-center">Tidak ada data.</td>
</tr>
@endforelse

        </tbody>

    </table>
    <div class="d-flex justify-content-end mt-5">
      {{ $assets->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
@section('script')
@endsection

