@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- Flash Messages --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <form action="{{ route('report.storeDataScale') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="date" class="form-label">Tanggal</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="date" name="tanggal" id="tanggal" class="form-control mb-2" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="asset" class="form-label">Nama Alat</label>
                        </div>
                        <div class="col-sm-10">
                            <select name="asset" id="asset" class="form-control mb-2" required>
                                <option value="" hidden>Pilih Asset</option>
                                @foreach($assets as $asset)
                                <option value="{{$asset->uuid}}" data-resolution="{{$asset->resolution}}">
                                    {{$asset->merk}} {{$asset->type}} {{$asset->series_number}} ({{$asset->department->department}})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="initial_temp" class="form-label">Temperatur Lingkungan</label>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <label for="initial_temp" class="form-label">Awal</label>
                            <input type="number" name="initial_temp" id="initial_temp" step="0.1" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="final_temp" class="form-label">Akhir</label>
                            <input type="number" name="final_temp" id="final_temp" step="0.1" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="initial_rh" class="form-label">RH Lingkungan</label>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <label for="initial_rh" class="form-label">Awal</label>
                            <input type="number" name="initial_rh" id="initial_rh" step="0.1" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="final_rh" class="form-label">Akhir</label>
                            <input type="number" name="final_rh" id="final_rh" step="0.1" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="scale_spec" class="form-label">Spek Timbangan</label>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <label for="max_weight" class="form-label">Berat Maksimal</label>
                            <input type="number" name="max_weight" id="max_weight" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="max_scale" class="form-label">Skala Maksimal</label>
                            <input type="number" name="max_scale" id="max_scale" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="scale_resolution" class="form-label">Resolusi Timbangan (e)</label>
                            <input type="number" name="scale_resolution" id="scale_resolution" step="0.00001" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="scale_class" class="form-label">Kelas Timbangan</label>
                            <input type="number" name="scale_class" id="scale_class" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="Usert_weight" class="form-label">Usert Anak Timbang</label>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <label for="weight_resolution" class="form-label">Resolusi (d)</label>
                            <input type="number" name="weight_resolution" id="weight_resolution" step="0.1" class="form-control" value="0.5">
                        </div>
                        <div class="col-sm-3">
                            <label for="weight_max" class="form-label">Beban Maksimum</label>
                            <input type="number" name="weight_max" id="weight_max" step="0.0001" value="0.0064" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="weight_min" class="form-label">Beban Minimum</label>
                            <input type="number" name="weight_min" id="weight_min" step="0.000001" value="0.000024" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="k" class="form-label">K</label>
                            <input type="number" name="k" id="k" value="2" class="form-control">
                        </div>
                    </div>
                    <h3 class="mb-4">Uji 1 Weighing Performance</h3>
                    <div class="row">
                        <div class="col-sm-2">
                            <label class="form-label">Total</label>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                            <input type="number" name="total[]" id="total[]" class="form-control mb-2" readonly>
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label">Muatan 1</label>
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                            <input type="number" name="weight_1[]" id="weight_1[]" class="form-control mb-2">
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label">Muatan 2</label>
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                            <input type="number" name="weight_2[]" id="weight_2[]" class="form-control mb-2">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Penunjukan</label>
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="show[]" id="show[]" step="0.00001" class="form-control mb-2">
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Koreksi</label>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="correction[]" id="correction[]" step="0.00001" class="form-control mb-2" readonly>
                        </div>
                    </div>
                    <h3 class="mb-4">Uji 2 Repeatability</h3>
                    <div class="row mb-3">
                        <div class="col-sm-2">
                            <label for="avg_dev_repeatability" class="form-label">Overall Muatan AVG STDEV</label>
                            <input type="number" name="avg_dev_repeatability" id="avg_dev_repeatability" class="form-control" step="0.1" readonly>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-4">
                        <h5 class="mb-3">Muatan 5%</h5>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="weight_5" class="form-label">Muatan 5%</label>
                                <input type="number" name="weight_5" id="weight_5" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="average_5" class="form-label">Average</label>
                                <input type="number" name="average[]" id="average_5" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="sd_5" class="form-label">Standar Deviasi</label>
                                <input type="number" name="sd[]" id="sd_5" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="Urepeat_5" class="form-label">U Repeat</label>
                                <input type="number" name="Urepeat[]" id="Urepeat_5" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Penunjukan</label>
                                <div class="repeatability-show-group">
                                    <input type="number" name="repeatability_show_5[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_5[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_5[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_5[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_5[]" step="0.00001" class="form-control mb-2">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Koreksi</label>
                                <div class="repeatability-correction-group">
                                    <input type="number" name="repeatability_correction_5[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_5[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_5[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_5[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_5[]" step="0.00001" class="form-control mb-2" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded p-3 mb-4">
                        <h5 class="mb-3">Muatan 50%</h5>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="weight_50" class="form-label">Muatan 50%</label>
                                <input type="number" name="weight_50" id="weight_50" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="average_50" class="form-label">Average</label>
                                <input type="number" name="average[]" id="average_50" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="sd_50" class="form-label">Standar Deviasi</label>
                                <input type="number" name="sd[]" id="sd_50" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="Urepeat_50" class="form-label">U Repeat</label>
                                <input type="number" name="Urepeat[]" id="Urepeat_50" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Penunjukan</label>
                                <div class="repeatability-show-group">
                                    <input type="number" name="repeatability_show_50[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_50[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_50[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_50[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_50[]" step="0.00001" class="form-control mb-2">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Koreksi</label>
                                <div class="repeatability-correction-group">
                                    <input type="number" name="repeatability_correction_50[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_50[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_50[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_50[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_50[]" step="0.00001" class="form-control mb-2" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mb-4">
                        <h5 class="mb-3">Muatan 100%</h5>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="weight_100" class="form-label">Muatan 100%</label>
                                <input type="number" name="weight_100" id="weight_100" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="average_100" class="form-label">Average</label>
                                <input type="number" name="average[]" id="average_100" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="sd_100" class="form-label">Standar Deviasi</label>
                                <input type="number" name="sd[]" id="sd_100" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="Urepeat_100" class="form-label">U Repeat</label>
                                <input type="number" name="Urepeat[]" id="Urepeat_100" step="0.00001" class="form-control mb-2" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Penunjukan</label>
                                <div class="repeatability-show-group">
                                    <input type="number" name="repeatability_show_100[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_100[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_100[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_100[]" step="0.00001" class="form-control mb-2">
                                    <input type="number" name="repeatability_show_100[]" step="0.00001" class="form-control mb-2">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Koreksi</label>
                                <div class="repeatability-correction-group">
                                    <input type="number" name="repeatability_correction_100[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_100[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_100[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_100[]" step="0.00001" class="form-control mb-2" readonly>
                                    <input type="number" name="repeatability_correction_100[]" step="0.00001" class="form-control mb-2" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="mb-4">Uji 3 Eccentricity</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="weight_ecc" class="form-label">Muatan</label>
                            <input type="number" name="weight_ecc" id="weight_ecc" step="0.00001" class="form-control mb-2" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label for="average_ecc" class="form-label">Average</label>
                            <input type="number" name="average_ecc" id="average_ecc" step="0.00001" class="form-control mb-2" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="uecc" class="form-label">U Ecc</label>
                            <input type="number" name="uecc" id="uecc" step="0.00001" class="form-control mb-2" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-1">
                            <label class="form-label">Posisi</label>
                            <input type="text" class="form-control mb-2" readonly value="1"></input>
                            <input type="text" class="form-control mb-2" readonly value="2"></input>
                            <input type="text" class="form-control mb-2" readonly value="3"></input>
                            <input type="text" class="form-control mb-2" readonly value="4"></input>
                            <input type="text" class="form-control mb-2" readonly value="5"></input>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Penunjukan</label>
                            <input type="number" name="eccentricity_show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="eccentricity_show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="eccentricity_show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="eccentricity_show[]" step="0.00001" class="form-control mb-2">
                            <input type="number" name="eccentricity_show[]" step="0.00001" class="form-control mb-2">
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label">Koreksi</label>
                            <input type="number" name="eccentricity_correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="eccentricity_correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="eccentricity_correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="eccentricity_correction[]" step="0.00001" class="form-control mb-2" readonly>
                            <input type="number" name="eccentricity_correction[]" step="0.00001" class="form-control mb-2" readonly>
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label">Koreksi Mutlak</label>
                            <input type="number" name="eccentricity_abs_correction[]" class="form-control mb-2" readonly>
                            <input type="number" name="eccentricity_abs_correction[]" class="form-control mb-2" readonly>
                            <input type="number" name="eccentricity_abs_correction[]" class="form-control mb-2" readonly>
                            <input type="number" name="eccentricity_abs_correction[]" class="form-control mb-2" readonly>
                            <input type="number" name="eccentricity_abs_correction[]" class="form-control mb-2" readonly>
                        </div>
                        <div class="col-sm-4">
                            <img src="{{ url('/image/mapping.png') }}" alt="mapping">
                        </div>
                    </div>
                    <h3 class="mb-4">Uncertainty</h3>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <label class="form-label">U. Drift Anak Timbang</label>
                            <input type="number" name="UDrift_weight" id="UDrift_weight" class="form-control" step="0.00000000001" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">U. Daya Baca</label>
                            <input type="number" name="Ureadability" id="Ureadability" class="form-control" step="0.000000000001" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-3">
                            <label class="form-label">U. Anak Timbang Standar</label>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uweightstd[]" id="Uweightstd[]" step="0.000001" class="form-control mb-2" readonly>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">U. Bouyancy Udara</label>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Ubouyancy[]" id="Ubouyancy[]" step="0.00000000000001" class="form-control mb-2" readonly>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">UC</label>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="Uc[]" id="Uc[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <label for="avg_U95" class="form-label">U95</label>
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">U95</label>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="U95[]" id="U95[]" step="0.000000000001" class="form-control mb-2" readonly>
                            <input type="number" name="avg_U95" id="avg_U95" step="0.01" class="form-control mb-2" readonly>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
    </form>
</div>
@endsection
@section('script')
<script>
    //Koreksi Uji 1
    document.addEventListener('DOMContentLoaded', function() {
        const totalInputs = document.querySelectorAll('input[name="total[]"]');
        const showInputs = document.querySelectorAll('input[name="show[]"]');
        const correctionInputs = document.querySelectorAll('input[name="correction[]"]');

        function calculateCorrection(index) {
            const total = parseFloat(totalInputs[index].value) || 0;
            const show = parseFloat(showInputs[index].value) || 0;
            const correction = Math.round(total - show); // round to nearest integer
            correctionInputs[index].value = correction;
        }

        totalInputs.forEach((input, index) => {
            input.addEventListener('input', () => calculateCorrection(index));
        });

        showInputs.forEach((input, index) => {
            input.addEventListener('input', () => calculateCorrection(index));
        });
    });

    //U Drift AT
    document.addEventListener('DOMContentLoaded', function() {
        const weightMaxInput = document.getElementById('weight_max');
        const weightMinInput = document.getElementById('weight_min');
        const driftInput = document.getElementById('UDrift_weight');

        function calculateDrift() {
            const weightMax = parseFloat(weightMaxInput.value) || 0;
            const weightMin = parseFloat(weightMinInput.value) || 0;
            const drift = (0.5 * (weightMax - weightMin)) / Math.sqrt(3);
            driftInput.value = drift.toFixed(6); // Adjust precision as needed
        }

        // Trigger calculation when either input changes
        weightMaxInput.addEventListener('input', calculateDrift);
        weightMinInput.addEventListener('input', calculateDrift);

        // Optional: run on load if values are pre-filled
        calculateDrift();
    });

    //U. Daya Baca
    document.addEventListener('DOMContentLoaded', function() {
        const resolutionInput = document.getElementById('weight_resolution');
        const readabilityInput = document.getElementById('Ureadability');

        function calculateReadability() {
            const resolution = parseFloat(resolutionInput.value) || 0;
            const readability = (0.5 * resolution) / Math.sqrt(3) / 3;
            readabilityInput.value = readability.toFixed(12); // 12 decimal places for higher precision
        }

        resolutionInput.addEventListener('input', calculateReadability);

        // Optional: run on load if there's already a value
        calculateReadability();
    });
    document.addEventListener('DOMContentLoaded', function() {
        const maxWeightInput = document.getElementById('max_weight');
        const weight5 = document.getElementById('weight_5');
        const weight50 = document.getElementById('weight_50');
        const weight100 = document.getElementById('weight_100');

        function updateWeights() {
            const max = parseFloat(maxWeightInput.value) || 0;

            weight5.value = (max * 0.05).toFixed(5);
            weight50.value = (max * 0.5).toFixed(5);
            weight100.value = (max * 1).toFixed(5);
        }

        maxWeightInput.addEventListener('input', updateWeights);

        // Optional: initialize on page load if value exists
        updateWeights();
    });

    //UJI REPEATABILITY
    document.addEventListener('DOMContentLoaded', () => {
        const muatanConfigs = [{
                weightId: 'weight_5',
                showName: 'repeatability_show_5[]',
                correctionName: 'repeatability_correction_5[]',
                averageId: 'average_5',
                sdId: 'sd_5',
                urepeatId: 'Urepeat_5'
            },
            {
                weightId: 'weight_50',
                showName: 'repeatability_show_50[]',
                correctionName: 'repeatability_correction_50[]',
                averageId: 'average_50',
                sdId: 'sd_50',
                urepeatId: 'Urepeat_50'
            },
            {
                weightId: 'weight_100',
                showName: 'repeatability_show_100[]',
                correctionName: 'repeatability_correction_100[]',
                averageId: 'average_100',
                sdId: 'sd_100',
                urepeatId: 'Urepeat_100'
            },
        ];

        const calculateAvgDevRepeatability = () => {
            const sdInputs = ['sd_5', 'sd_50', 'sd_100'];
            const sdValues = sdInputs.map(id => parseFloat(document.getElementById(id).value)).filter(val => !isNaN(val));

            if (sdValues.length > 0) {
                const avg = sdValues.reduce((a, b) => a + b, 0) / sdValues.length;
                document.getElementById('avg_dev_repeatability').value = avg.toFixed(5);
            } else {
                document.getElementById('avg_dev_repeatability').value = '';
            }
        };

        muatanConfigs.forEach(cfg => {
            const showInputs = document.getElementsByName(cfg.showName);
            const correctionInputs = document.getElementsByName(cfg.correctionName);
            const weightInput = document.getElementById(cfg.weightId);
            const avgInput = document.getElementById(cfg.averageId);
            const sdInput = document.getElementById(cfg.sdId);
            const uRepeatInput = document.getElementById(cfg.urepeatId);

            const calculate = () => {
                const weight = parseFloat(weightInput.value) || 0;
                const values = [];

                showInputs.forEach((input, index) => {
                    const showVal = parseFloat(input.value);
                    if (!isNaN(showVal)) {
                        values.push(showVal);
                        const correction = weight - showVal;
                        correctionInputs[index].value = correction.toFixed(5);
                    } else {
                        correctionInputs[index].value = '';
                    }
                });

                if (values.length > 0) {
                    const avg = values.reduce((a, b) => a + b, 0) / values.length;
                    const variance = values.reduce((acc, val) => acc + Math.pow(val - avg, 2), 0) / values.length;
                    const sd = Math.sqrt(variance);
                    const uRepeat = sd / Math.sqrt(10);

                    avgInput.value = avg.toFixed(5);
                    sdInput.value = sd.toFixed(5);
                    uRepeatInput.value = uRepeat.toFixed(5);
                } else {
                    avgInput.value = '';
                    sdInput.value = '';
                    uRepeatInput.value = '';
                }

                // Call this to always update overall AVG STDEV
                calculateAvgDevRepeatability();
            };

            showInputs.forEach(input => input.addEventListener('input', calculate));
            weightInput.addEventListener('input', calculate);
        });
    });

    //U. AT Standar & Total weight 1 dan weight 2
    const weights = @json($weights);

    document.addEventListener('DOMContentLoaded', function() {
        const weight1Inputs = document.getElementsByName('weight_1[]');
        const weight2Inputs = document.getElementsByName('weight_2[]');
        const uweightstdInputs = document.getElementsByName('Uweightstd[]');
        const totalInputs = document.getElementsByName('total[]');
        const ubouyancyInputs = document.getElementsByName('Ubouyancy[]');
        const ucInputs = document.getElementsByName('Uc[]');
        const u95Inputs = document.getElementsByName('U95[]');
        const avgU95Input = document.getElementById('avg_U95'); // 👈 for final average

        const UDrift_weightInput = document.getElementById('UDrift_weight');
        const UreadabilityInput = document.getElementById('Ureadability');
        const avg_dev_repeatabilityInput = document.getElementById('avg_dev_repeatability');
        const UeccInput = document.getElementById('uecc');

        for (let i = 0; i < weight1Inputs.length; i++) {
            weight1Inputs[i].addEventListener('input', () => {
                calculateUweight(i);
                calculateTotal(i);
                calculateUbouyancy(i);
                calculateUc(i);
            });

            weight2Inputs[i].addEventListener('input', () => {
                calculateUweight(i);
                calculateTotal(i);
                calculateUbouyancy(i);
                calculateUc(i);
            });
        }

        function calculateUweight(index) {
            const weight1 = parseFloat(weight1Inputs[index].value);
            const weight2 = parseFloat(weight2Inputs[index].value);

            const w1Match = !isNaN(weight1) ? weights.find(w => Math.abs(w.mass - weight1) < 0.5) : null;
            const w2Match = (!isNaN(weight2) && weight2 !== 0) ? weights.find(w => Math.abs(w.mass - weight2) < 0.5) : null;

            let result = '';

            if (w1Match && !w2Match) {
                result = w1Match.error * 0.001 / 2;
            } else if (w1Match && w2Match) {
                result = ((w1Match.error * 0.001) + (w2Match.error * 0.001)) / 2;
            }

            uweightstdInputs[index].value = result !== '' ? result.toFixed(6) : '';
        }

        function calculateTotal(index) {
            const weight1 = parseFloat(weight1Inputs[index].value) || 0;
            const weight2 = parseFloat(weight2Inputs[index].value) || 0;
            const total = weight1 + weight2;
            totalInputs[index].value = Math.round(total);
        }

        function calculateUbouyancy(index) {
            const weight1 = parseFloat(weight1Inputs[index].value) || 0;
            const weight2 = parseFloat(weight2Inputs[index].value) || 0;
            const total = weight1 + weight2;
            const result = (total / 1000000) / Math.sqrt(3);
            ubouyancyInputs[index].value = result.toFixed(14);
        }

        function calculateUc(index) {
            const Uweightstd = parseFloat(uweightstdInputs[index]?.value) || 0;
            const Ubouyancy = parseFloat(ubouyancyInputs[index]?.value) || 0;

            const UDrift_weight = parseFloat(UDrift_weightInput?.value) || 0;
            const Ureadability = parseFloat(UreadabilityInput?.value) || 0;
            const avg_dev_repeatability = parseFloat(avg_dev_repeatabilityInput?.value) || 0;
            const Uecc = parseFloat(UeccInput?.value) || 0;

            const result = Math.sqrt(
                Math.pow(Uweightstd, 2) +
                Math.pow(UDrift_weight, 2) +
                Math.pow(Ureadability, 2) +
                Math.pow(Ubouyancy, 2) +
                Math.pow(avg_dev_repeatability, 2) +
                Math.pow(Uecc, 2)
            );

            ucInputs[index].value = result.toFixed(12);

            // 👉 Calculate U95 = UC * 2
            const u95 = result * 2;
            u95Inputs[index].value = u95.toFixed(12);

            // 👉 Update average of U95
            calculateAvgU95();
        }

        function calculateAvgU95() {
            let total = 0;
            let count = 0;

            for (let i = 0; i < u95Inputs.length; i++) {
                const value = parseFloat(u95Inputs[i].value);
                if (!isNaN(value)) {
                    total += value;
                    count++;
                }
            }

            const avg = count > 0 ? total / count : 0;
            avgU95Input.value = avg.toFixed(2);
        }
    });

    //UJI Eccentricitiy
    const weightEccInput = document.getElementById('weight_ecc');
    const maxWeightInput = document.getElementById('max_weight');
    const showInputs = document.getElementsByName('eccentricity_show[]');
    const correctionInputs = document.getElementsByName('eccentricity_correction[]');
    const absCorrectionInputs = document.getElementsByName('eccentricity_abs_correction[]');
    const averageEccInput = document.getElementById('average_ecc');
    const ueccInput = document.getElementById('uecc');

    function updateCorrections() {
        const weightEcc = parseFloat(weightEccInput.value);
        if (isNaN(weightEcc)) return;

        let sum = 0;
        let count = 0;
        let maxCorrection = null;
        let maxAbsCorrection = null;

        showInputs.forEach((input, index) => {
            const showValue = parseFloat(input.value);

            if (isNaN(showValue)) {
                correctionInputs[index].value = '';
                absCorrectionInputs[index].value = '';
            } else {
                const correction = weightEcc - showValue;
                const absCorrection = Math.abs(correction);

                correctionInputs[index].value = correction.toFixed(5);
                absCorrectionInputs[index].value = absCorrection.toFixed(5);

                sum += showValue;
                count++;

                // Track max values
                if (maxCorrection === null || correction > maxCorrection) {
                    maxCorrection = correction;
                }

                if (maxAbsCorrection === null || absCorrection > maxAbsCorrection) {
                    maxAbsCorrection = absCorrection;
                }
            }
        });

        // Average
        const average = count > 0 ? (sum / count).toFixed(5) : '';
        averageEccInput.value = average;

        // UECC
        if (maxCorrection !== null && maxAbsCorrection !== null) {
            const uecc = (maxCorrection * maxAbsCorrection) / 8000;
            ueccInput.value = uecc.toFixed(5);
        } else {
            ueccInput.value = '';
        }
    }

    // When max_weight changes
    maxWeightInput.addEventListener('input', function() {
        const maxWeight = parseFloat(this.value);
        const weightEcc = isNaN(maxWeight) ? '' : (maxWeight / 3).toFixed(5);
        weightEccInput.value = weightEcc;

        updateCorrections(); // update everything
    });

    // When any eccentricity_show[] input changes
    showInputs.forEach(input => {
        input.addEventListener('input', updateCorrections);
    });
</script>
@endsection