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
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  padding: 24px 36px;
  transition: all 0.3s ease;
  text-align: left;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 270px;
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

.stat-card-custom:hover .image-card {
  filter: grayscale(0%);
  opacity: 1;
}

.image-card {
  width: 85%;
  opacity: 0.7;
  position: absolute;
  top: -9rem;
  right: -10.1rem;
  filter: grayscale(30%);
  transition: all 0.3s ease;
}

.stat-title {
  font-size: 1.3rem;
  color: #566A7F;
  font-weight: 600;
  text-transform: uppercase;
  width: 80%;
  margin-bottom: .5rem;
  margin-top: 1rem;
  text-transform: uppercase;
  word-wrap: break-word;
  z-index: 99;
}

.stat-value {
  font-size: 3rem;
  margin-left: 1rem;
  font-weight: bold;
  color: #343a40;
  z-index: 99;
}

.tooltip-custom {
  position: absolute;
  display: none;
  background: rgb(66, 73, 92);
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
  font-size: 12px;
  z-index: 999;
  pointer-events: none;
}

.tooltip-custom::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 20%;
  margin-left: -5px;
  width: 0;
  height: 0;
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 6px solid rgb(66, 73, 92);
}

</style>
@endsection
@section('content')
{{-- total section --}}
<div class="container width-full mx-0 px-0 mt-4">
  <div class="row g-5">
    <div class="col-md-6">
      <div class="stat-card-custom" id="totalAssetCard" style="cursor: pointer;">
        <img src="{{ url('/image/asset.svg') }}" alt="asset" class="image-card">
        <div class="stat-title">TOTAL MESIN DAN PERALATAN</div>
        <div class="stat-value">{{ $totalAssets }}</div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="stat-card-custom" id="totalCalibratedCard" style="cursor: pointer;">
        <img src="{{ url('/image/done.svg') }}" alt="asset" class="image-card">
        <div class="stat-title">TOTAL ALAT SUDAH KALIBRASI</div>
        <div class="stat-value">{{ $calibratedCount }}</div>
      </div>
    </div>
    <div class="col-md-6">
      <a href="{{ route('dashboard.toggleTable', 'onTrackTable') }}" style="text-decoration: none;">
        <div class="stat-card-custom" id="onTrackCard" style="cursor: pointer;">
          <img src="{{ url('/image/ontrack.svg') }}" alt="asset" class="image-card">
          <div class="stat-title">TOTAL ALAT ON TRACK KALIBRASI</div>
          <div class="stat-value">{{ $onTrackCount }}</div>
        </div>
      </a>
    </div>
    <div class="col-md-6">
      <a href="{{ route('dashboard.toggleTable', 'onEDTable') }}" style="text-decoration: none;">
        <div class="stat-card-custom" id="onEDCard" style="cursor: pointer;">
          <img src="{{ url('/image/ED.svg') }}" alt="asset" class="image-card">
          <div class="stat-title">TOTAL ALAT MENDEKATI ED KALIBRASI</div>
          <div class="stat-value">{{ $approachingEDCount }}</div>
        </div>
      </a>
    </div>
  </div>
  <div id="customTooltip" class="tooltip-custom"></div>
</div>

{{-- data alat on track kalibrasi --}}
@if(session('onTrackTable'))
  <div class="table-responsive text-nowrap mt-5 bg-white shadow px-5 py-5" id="onTrackTable" style="border-radius: 16px;">
      <h3 class="text-center mb-5">DATA ALAT PROSES KALIBRASI</h3>
      <table class="table table-bordered text-center align-middle">
          <thead>
              <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                  <th style="color: #fff">No.</th>
                  <th style="color: #fff">Nama Alat</th>
                  <th style="color: #fff">Merk</th>
                  <th style="color: #fff">Serial Number</th>
                  <th style="color: #fff">Departemen</th>
                  <th style="color: #fff">ED Sertifikat</th>
                  <th style="color: #fff">Kalibrasi</th>
                  <th style="color: #fff">Progress</th>
                  <th style="color: #fff">Status</th>
                  <th style="color: #fff">Reminder</th>
              </tr>
          
          </thead>
          <tbody>
            @forelse ($onTrackAsset as $index => $onTrackAssets)
              <tr>
                  <th>{{ $loop->iteration }}</th>
                  <td>{{ $onTrackAssets->asset->category->category }}</td>
                  <td>{{ $onTrackAssets->asset->merk }}</td>
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
@endif

{{-- data alat mendekati ED --}}
@if(session('onEDTable'))
  <div class="table-responsive text-nowrap mt-5 bg-white shadow px-5 py-5" id="onEDTable" style="border-radius: 16px;">
      <h3 class="text-center mb-5">DATA ALAT MENDEKATI ED KALIBRASI</h3>

      <div class="row mx-0 px-0">
          <div class="col-md-12 d-flex justify-content-end mx-0 px-0">
              <form id="searchForm" method="GET" action="{{ route('dashboard') }}" class=" d-flex align-items-center gap-2">
                  <div class="input-group mb-3">
                      <input type="search" class="form-control" placeholder="Ketik untuk mencari" name="search" value="{{ request('search') }}">
                      <button class="btn btn-info" type="submit">Search</button>
                      <a href="{{ route('dashboard') }}" class="btn-reset btn btn-primary">Reset</a>
                  </div>
              </form>
          </div>
      </div>

      <table class="table table-bordered text-center align-middle">
          <thead>
              <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                  <th style="color: #fff">No.</th>
                  <th style="color: #fff">Nama Alat</th>
                  <th style="color: #fff">Merk</th>
                  <th style="color: #fff">Serial Number</th>
                  <th style="color: #fff">Departemen</th>
                  <th style="color: #fff">ED Sertifikat</th>
                  <th style="color: #fff">
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
                        ]) }}" class="d-flex align-items-center justify-content-center gap-1 text-decoration-none" style="color: #fff;">
                        <span>KALIBRASI</span>
                        @if ($isSorted)
                            @if ($currentDirection === 'asc')
                                <i class='bx bx-sort-a-z bx-xs text-white'></i>
                            @else
                                <i class='bx bx-sort-z-a bx-xs text-white'></i>
                            @endif
                        @else
                            <i class='bx bx-sort-a-z bx-xs'></i>
                        @endif
                    </a>
                </th>
                <th style="color: #fff">reminder</th>
              </tr>
          </thead>
          <tbody>
          @forelse ($assets as $index => $asset)
          <tr>
              <td>{{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}</td>
              <td>{{ $asset->category->category }}</td>
              <td>{{ $asset->merk }}</td>
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
      <div class="d-flex justify-content-end mt-4">
        {{ $assets->links('pagination::bootstrap-5') }}
      </div>

  </div>
@endif

@endsection

@section('script')
<script>
  // card control
  document.addEventListener("DOMContentLoaded", function () {

    const redirectOnClick = (cardId, url) => {
      const card = document.getElementById(cardId);
      if (card) {
        card.addEventListener("click", () => {
          window.location.href = url;
        });
      }
    };

    redirectOnClick("totalAssetCard", "/asset");
    redirectOnClick("totalCalibratedCard", "/calibration/calibrated-assets");
  });

  // tooltips
  document.addEventListener("DOMContentLoaded", function () {
    const tooltip = document.getElementById("customTooltip");

    const cardsWithTooltip = [
      { id: "onTrackCard", message: "Click to view On Track Assets" },
      { id: "onEDCard", message: "Click to view Expiring Assets" },
      { id: "totalAssetCard", message: "Click to view All Assets" },
      { id: "totalCalibratedCard", message: "Click to view Calibrated Assets" },
    ];

    cardsWithTooltip.forEach(({ id, message }) => {
      const card = document.getElementById(id);
      if (card) {
        card.addEventListener("mousemove", function (e) {
          tooltip.style.display = "block";
          tooltip.textContent = message;
          tooltip.style.left = e.pageX + 95 + "px";
          tooltip.style.top = e.pageY + 0 + "px";
        });

        card.addEventListener("mouseleave", function () {
          tooltip.style.display = "none";
        });
      }
    });
  });
</script>
@endsection

