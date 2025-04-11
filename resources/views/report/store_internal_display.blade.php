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
    <div class="card">
        <div class="card-body">
            <form action="{{ route('report.storeDataDisplay') }}" method="POST">
                @csrf
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
                    <div id="form-container">
                        <div class="form-set">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="set_suhu" class="form-label">Set Suhu</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="number" name="set_suhu[]" class="form-control mb-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="form-label">Penunjukan Standar</label>
                                    <input type="number" name="standar1[]" step="0.01" class="form-control mb-2 standar">
                                    <input type="number" name="standar2[]" step="0.01" class="form-control mb-2 standar">
                                    <input type="number" name="standar3[]" step="0.01" class="form-control mb-2 standar">
                                    <input type="number" name="standar4[]" step="0.01" class="form-control mb-2 standar">
                                    <input type="number" name="standar5[]" step="0.01" class="form-control mb-2 standar">
                                    <label class="form-label">Rata-rata penunjukan standar</label>
                                    <input type="number" name="avgprt[]" step="0.01" class="form-control mb-2 avgprt" readonly>
                                    <label class="form-label">Standar deviasi penunjukan alat</label>
                                    <input type="number" name="stdevprt[]" step="0.01" class="form-control mb-2 stdevprt" readonly>
                                    <label for="correction" class="form-label">Koreksi</label>
                                    <input type="number" name="correction[]" step="0.01" class="form-control mb-2 correction" readonly>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Penunjukan Alat</label>
                                    <input type="number" name="aktual1[]" step="0.01" class="form-control mb-2 aktual">
                                    <input type="number" name="aktual2[]" step="0.01" class="form-control mb-2 aktual">
                                    <input type="number" name="aktual3[]" step="0.01" class="form-control mb-2 aktual">
                                    <input type="number" name="aktual4[]" step="0.01" class="form-control mb-2 aktual">
                                    <input type="number" name="aktual5[]" step="0.01" class="form-control mb-2 aktual">
                                    <label class="form-label">Rata-rata penunjukan alat</label>
                                    <input type="number" name="avguut[]" step="0.01" class="form-control mb-2 avguut" readonly>
                                    <label class="form-label">Standar deviasi penunjukan alat</label>
                                    <input type="number" name="stdevuut[]" step="0.01" class="form-control mb-2 stdevuut" readonly>
                                    <label class="form-label">U4</label>
                                    <input type="number" name="u4prt[]" step="0.01" class="form-control mb-2 u4prt" readonly>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="avg_stdev_uut" class="form-label">Rata-rata standar deviasi penunjukan Alat</label>
                        <input type="number" name="avg_stdev_uut" id="avg_stdev_uut" class="form-control mb-2 u4prt" readonly>
                        <label for="u2" class="form-label">U2</label>
                        <input type="number" name="u2" id="u2" step="0.01" class="form-control mb-2" readonly>
                        <label for="uc" class="form-label">UC</label>
                        <input type="number" name="uc" id="uc" step="0.01" class="form-control mb-2" readonly>
                        <label for="veff" class="form-label">Veff</label>
                        <input type="number" name="veff" id="veff" step="0.01" class="form-control mb-2" readonly>
                    </div>
                    <div class="col-sm-6">
                        <label for="u1" class="form-label">U1</label>
                        <input type="number" name="u1" id="u1" step="0.01" class="form-control mb-2" readonly>
                        <label for="u3" class="form-label">U3</label>
                        <input type="number" name="u3" id="u3" step="0.01" class="form-control mb-2" readonly>
                        <label for="k" class="form-label">K</label>
                        <input type="number" name="k" id="k" step="0.01" class="form-control mb-2" value="2" readonly>
                        <label for="u95" class="form-label">U95</label>
                        <input type="number" name="u95" id="u95" step="0.01" class="form-control mb-2" readonly>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-primary" id="add-form">Tambah Set Suhu</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    document.getElementById("add-form").addEventListener("click", function() {
        let container = document.getElementById("form-container");
        let originalForm = container.querySelector(".form-set");
        let clonedForm = originalForm.cloneNode(true);

        // Reset input values in the cloned form
        clonedForm.querySelectorAll("input").forEach(input => {
            if (!input.readonly) input.value = "";
        });

        container.appendChild(clonedForm);
        setupListeners(); // Reattach event listeners to new fields
    });

    function calculateStats(formSet, fieldClass, avgClass, stdevClass) {
        let inputs = formSet.querySelectorAll("." + fieldClass);
        let values = Array.from(inputs).map(input => parseFloat(input.value)).filter(val => !isNaN(val));

        if (values.length === 0) {
            formSet.querySelector("." + avgClass).value = "";
            formSet.querySelector("." + stdevClass).value = "";
            return;
        }

        let sum = values.reduce((a, b) => a + b, 0);
        let mean = sum / values.length;

        let variance = values.reduce((sum, val) => sum + Math.pow(val - mean, 2), 0) / values.length;
        let stdev = Math.sqrt(variance);

        formSet.querySelector("." + avgClass).value = mean.toFixed(5);
        formSet.querySelector("." + stdevClass).value = stdev.toFixed(5);

        // Recalculate correction after updating averages
        calculateCorrection(formSet);
    }

    function calculateU4(formSet) {
        let stdevuut = parseFloat(formSet.querySelector(".stdevuut").value);
        if (!isNaN(stdevuut)) {
            formSet.querySelector(".u4prt").value = (stdevuut / Math.sqrt(5)).toFixed(5);
        } else {
            formSet.querySelector(".u4prt").value = "";
        }
        calculateUc(); // Ensure UC updates when U4 changes
    }

    function calculateCorrection(formSet) {
        let avgprt = parseFloat(formSet.querySelector(".avgprt").value);
        let avguut = parseFloat(formSet.querySelector(".avguut").value);

        if (!isNaN(avgprt) && !isNaN(avguut)) {
            formSet.querySelector(".correction").value = (avgprt - avguut).toFixed(5);
        } else {
            formSet.querySelector(".correction").value = "";
        }
    }

    function calculateAvgStdevUut() {
        let stdevuutInputs = document.querySelectorAll(".stdevuut");
        let values = Array.from(stdevuutInputs)
            .map(input => parseFloat(input.value))
            .filter(val => !isNaN(val));

        if (values.length === 0) {
            document.getElementById("avg_stdev_uut").value = "";
            return;
        }

        let sum = values.reduce((a, b) => a + b, 0);
        let avgStdevUut = sum / values.length;

        document.getElementById("avg_stdev_uut").value = avgStdevUut.toFixed(5);
    }

    function calculateU1() {
        let dummyData = 0.6; // Replace with actual database value when available
        document.getElementById("u1").value = (dummyData / 2).toFixed(5);
        calculateUc(); // Ensure UC updates when U1 changes
    }

    function calculateU2() {
        let dummyData = 0.46; // Replace with actual database value when available
        document.getElementById("u2").value = ((0.5 * dummyData) / Math.sqrt(3)).toFixed(5);
        calculateUc(); // Ensure UC updates when U2 changes
    }

    function calculateU3() {
        let assetSelect = document.getElementById("asset");
        let selectedAssetResolution = assetSelect.options[assetSelect.selectedIndex].getAttribute("data-resolution");

        if (selectedAssetResolution) {
            let resolution = parseFloat(selectedAssetResolution);
            if (!isNaN(resolution)) {
                document.getElementById("u3").value = ((0.5 * resolution) / Math.sqrt(3)).toFixed(5);
            } else {
                document.getElementById("u3").value = "";
            }
        }
        calculateUc(); // Ensure UC updates when U3 changes
    }

    function calculateUc() {
        let u1 = parseFloat(document.getElementById("u1").value) || 0;
        let u2 = parseFloat(document.getElementById("u2").value) || 0;
        let u3 = parseFloat(document.getElementById("u3").value) || 0;

        let u4Inputs = document.querySelectorAll(".u4prt");
        let u4Values = Array.from(u4Inputs)
            .map(input => parseFloat(input.value) || 0)
            .filter(val => !isNaN(val));

        let avgU4 = u4Values.length ? (u4Values.reduce((sum, val) => sum + val, 0) / u4Values.length) : 0;

        let uc = Math.sqrt((u1 ** 2) + (u2 ** 2) + (u3 ** 2) + (avgU4 ** 2));

        document.getElementById("uc").value = uc.toFixed(5);

        calculateU95(); // Ensure U95 updates after UC
    }

    function calculateU95() {
        let uc = parseFloat(document.getElementById("uc").value) || 0;
        let k = parseFloat(document.getElementById("k").value) || 2;

        document.getElementById("u95").value = (uc * k).toFixed(5);
    }

    function setupListeners() {
        document.querySelectorAll(".form-set").forEach(formSet => {
            formSet.querySelectorAll(".standar").forEach(input => {
                input.addEventListener("input", function() {
                    calculateStats(formSet, "standar", "avgprt", "stdevprt");
                });
            });

            formSet.querySelectorAll(".aktual").forEach(input => {
                input.addEventListener("input", function() {
                    calculateStats(formSet, "aktual", "avguut", "stdevuut");
                    calculateU4(formSet);
                    calculateAvgStdevUut();
                    calculateUc(); // Ensure UC recalculates when values change
                });
            });

            formSet.querySelector(".avgprt").addEventListener("input", function() {
                calculateCorrection(formSet);
            });

            formSet.querySelector(".avguut").addEventListener("input", function() {
                calculateCorrection(formSet);
            });
        });

        document.getElementById("asset").addEventListener("change", function() {
            calculateU3();
            calculateUc(); // Update UC when asset changes
        });

        document.getElementById("u1").addEventListener("input", calculateUc);
        document.getElementById("u2").addEventListener("input", calculateUc);
        document.getElementById("u3").addEventListener("input", calculateUc);
        document.querySelectorAll(".u4prt").forEach(input => input.addEventListener("input", calculateUc));
    }

    // Run calculations on page load
    window.onload = function() {
        calculateU1();
        calculateU2();
        calculateU3();
        setupListeners();
    };
</script>
@endsection