@extends('templates.templates')
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

.stat-card-custom:hover .image-card {
  filter: grayscale(0%);
  opacity: 1;
}

.image-card {
  width: 90%;
  opacity: 0.7;
  position: absolute;
  top: -4.5rem;
  right: -5rem;
  filter: grayscale(30%);
  transition: all 0.3s ease;
}

.stat-title {
  font-size: 0.9rem;
  color: #566A7F;
  font-weight: 600;
  text-transform: uppercase;
  width: 80%; /* atau bisa 80% kalau ingin lebih sempit */
  margin-bottom: .5rem;
  margin-top: 1.5rem;
  text-transform: uppercase;
  word-wrap: break-word;
  z-index: 99;
}

.stat-value {
  font-size: 2.2rem;
  margin-left: .5rem;
  font-weight: bold;
  color: #343a40;
  z-index: 99;
}
</style>
@endsection
@section('content')

<div class="container width-full mx-0 px-0 mt-4">
    <div class="row g-3">
      <div class="col-md-3">
        <div class="stat-card-custom">
          <img src="{{ url('/image/ed.svg') }}" alt="asset" class="image-card">
          <div class="stat-title">TOTAL ALAT TELAT KALIBRASI</div>
          <div class="stat-value">{{ $expiredCount }}</div>
        </div>
      </div>
    </div>
</div>

    {{-- data alat mendekati ED --}}
<div class="table-responsive text-nowrap mt-5 bg-white shadow px-5 py-5" style="border-radius: 16px;">
    <h2 class="mb-4 text-center">DATA ALAT TELAT KALIBRASI</h2>

    <div class="row mx-0 px-0">
        <div class="col-md-12 d-flex justify-content-end mx-0 px-0">
            <form id="searchForm" method="GET" action="{{ route('late-calibration') }}" class=" d-flex align-items-center gap-2">
                <div class="input-group mb-3">
                    <input type="search" class="form-control" placeholder="Ketik untuk mencari" name="search" value="{{ request('search') }}">
                    <button class="btn btn-info" type="submit">Search</button>
                    <a href="{{ route('late-calibration') }}" class="btn-reset btn btn-primary">Reset</a>
                </div>
            </form>
        </div>
    </div>
    

    <table class="table table-bordered text-center align-middle mt-4">
        <thead>
            <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                <th style="color: #fff">No.</th>
                <th style="color: #fff">Nama Alat</th>
                <th style="color: #fff">Merk</th>
                <th style="color: #fff">Serial Number</th>
                <th style="color: #fff">Departemen</th>
                <th style="color: #fff">ED Sertifikat</th>
                <th style="color: #fff">Kalibrasi</th>
            </tr>
        
        </thead>
        <tbody>
        @forelse ($expiredAssets as $index => $asset)
        <tr>
            <td>{{ ($expiredAssets->currentPage() - 1) * $expiredAssets->perPage() + $loop->iteration }}</td>
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
            <td>{{ $asset->category->calibration }}</td> <!-- Kalibrasi -->
        </tr>
        @empty
        <tr>
            <td colspan="10" class="text-center">Tidak ada data.</td>
        </tr>
        @endforelse

        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-4">
        {{ $expiredAssets->links('pagination::bootstrap-5') }}
    </div>
</div>
</div>
@endsection
@section('script')
<script>
    // Optional: You can implement JavaScript to handle dynamic form population, if necessary.
</script>
@endsection