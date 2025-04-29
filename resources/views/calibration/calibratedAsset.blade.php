@extends('templates.templates')
@section('style')
<style>
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
            <div class="row g-4">
              <div class="col-md-3">
                <div class="stat-card-custom">
                  <img src="{{ url('/image/ed.svg') }}" alt="asset" class="image-card">
                  <div class="stat-title">TOTAL ALAT TERKALIBRASI YANG BELUM UPLOAD SERTIFIKAT</div>
                  <div class="stat-value">{{ $missingCalibrationCount }}</div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="stat-card-custom">
                  <img src="{{ url('/image/done.svg') }}" alt="asset" class="image-card">
                  <div class="stat-title">TOTAL ALAT TERKALIBRASI YANG SUDAH UPLOAD SERTIFIKAT</div>
                  <div class="stat-value">{{ $certifiedAssetsCount }}</div>
                </div>
              </div>
            </div>
        </div>


    {{-- data alat terkalibrasi --}}
    <div class="table-responsive text-nowrap mt-5 bg-white shadow px-5 py-5" style="border-radius: 16px;">
        <h3 class="mb-5 text-center">DATA ALAT TERKALIBRASI YANG BELUM UPLOAD SERTIFIKAT</h3>

        <table class="table table-bordered text-center align-middle mt-5">
        <thead>
            <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                <th style="color: #fff">No.</th>
                <th style="color: #fff">Nama Alat</th>
                <th style="color: #fff">Serial Number</th>
                <th style="color: #fff">Departemen</th>
                <th style="color: #fff">ED Sertifikat</th>
                <th style="color: #fff">Kalibrasi</th>
            </tr>

        </thead>
        <tbody>
            @forelse ($missingCalibrationAsset as $index => $asset)
            <tr>
                <td>{{ ($missingCalibrationAsset->currentPage() - 1) * $missingCalibrationAsset->perPage() + $loop->iteration }}</td>
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
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse

        </tbody>
        </table>
        <div class="d-flex justify-content-end mt-4">
        {{ $missingCalibrationAsset->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- data alat terkalibrasi --}}
    <div class="table-responsive text-nowrap mt-5 bg-white shadow px-5 py-5" style="border-radius: 16px;">
        <h3 class="mb-5 text-center">DATA ALAT TERKALIBRASI YANG SUDAH UPLOAD SERTIFIKAT</h3>
        <table class="table table-bordered text-center align-middle mt-3">
            <thead>
                <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                    <th style="color: #fff">No.</th>
                    <th style="color: #fff">Nama Alat</th>
                    <th style="color: #fff">Serial Number</th>
                    <th style="color: #fff">Departemen</th>
                    <th style="color: #fff">ED Sertifikat</th>
                    <th style="color: #fff">Kalibrasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($certifiedAssets as $index => $asset)
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
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
    </div>

</div>
@endsection
@section('script')
<script>
    // Optional: You can implement JavaScript to handle dynamic form population, if necessary.
</script>
@endsection