<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calibration Certificate</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }

        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }

        /* Transparent Border Table */
        .table-transparent {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-transparent th,
        .table-transparent td {
            border: none;
            padding: 2px;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table class="table-transparent">
        <tr>
            <td style="width: 10%;">
                <img src="{{ storage_path('app/logo.png') }}" alt="Company Logo" style="width: 50px;">
            </td>
            <td>
                <h2 style="text-align: center;">PT CHAROEN POKPHAND INDONESIA</h2>
                <h2 style="text-align: center;">CALIBRATION CERTIFICATE</h2>
            </td>
        </tr>
    </table>

    <!-- Certificate Information -->
    <table class="table-transparent">
        <tr>
            <td style="width: 16%;">
                <i>Certificate Number</i>
            </td>
            <td style="width: 5%;">
                :
            </td>
            <td>
                {{$scale->certificate_number}}
            </td>
            <td> </td>
            <td colspan="4">Environmental Condition</td>
        </tr>
        <tr>
            <td>
                <i>Page</i>
            </td>
            <td>
                :
            </td>
            <td>
                1 of 1
            </td>
            <td> </td>
            <td rowspan="2" style="width: 8%;">Initial</td>
            <td style="width: 8%;"> T (°C)</td>
            <td style="width: 5%;">:</td>
            <td style="width: 10%;">{{round($scale->initial_temp)}}°C</td>
        </tr>
        <tr>
            <td>
                Calibration Date
            </td>
            <td>
                :
            </td>
            <td>{{$scale->calibration_date}}</td>
            <td></td>
            <td>RH(%)</td>
            <td>:</td>
            <td>{{round($scale->initial_rh)}}%</td>
        </tr>
        <tr>
            <td colspan="4"> </td>
            <td rowspan="2">Final</td>
            <td> T (°C)</td>
            <td>:</td>
            <td>{{round($scale->final_temp)}}°C</td>
        </tr>
        <tr>
            <td colspan="4"> </td>
            <td>RH(%)</td>
            <td>:</td>
            <td>{{round($scale->final_rh)}}%</td>
        </tr>
    </table>
    <br>
    <table class="table-transparent">
        <tr>
            <td colspan="3"><b><i>INSTRUMENT IDENTIFICATION</i></b></td>
            <td></td>
            <td colspan="3"><b><i>STANDARD USED</i></b></td>
        </tr>
        <tr>
            <td style="width: 16%;">Instrument Name</td>
            <td style="width: 5%;">:</td>
            <td style="width: 16%;">{{$scale->asset->category->category}}</td>
            <td></td>
            <td style="width: 16%;">Instrument Name</td>
            <td style="width: 5%;">:</td>
            <td style="width: 10%;">Standard M1</td>
        </tr>
        <tr>
            <td>Manufacturer</td>
            <td>:</td>
            <td>{{$scale->asset->merk}}</td>
            <td rowspan="4"></td>
        </tr>
        <tr>
            <td>Model/Type</td>
            <td>:</td>
            <td>{{$scale->asset->type}}</td>
            <td rowspan="4"></td>
        </tr>
        <tr>
            <td>Serial Number</td>
            <td>:</td>
            <td>{{$scale->asset->series_number}}</td>
            <td rowspan="4"></td>
        </tr>
        <tr>
            <td>Capacity/Readability</td>
            <td>:</td>
            <td>{{$scale->asset->capacity}}/{{$scale->asset->resolution}}g</td>
        </tr>
    </table>

    <!-- Calibration Report -->
    <h3>Calibration Report :</h3>
    <h3>1. WEIGHING PERFORMANCE</h3>
    <table class="table-bordered">
        <tr>
            <th>No.</th>
            <th>Muatan (g)</th>
            <th>Penunjukan (g)</th>
            <th>Koreksi (g)</th>
            <th>Uncertainty (U95%)</th>
        </tr>
        @foreach($scale->weighing_performances as $weighing)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{round($weighing->total)}}</td>
            <td>{{round($weighing->show)}}</td>
            <td>{{round($weighing->correction)}}</td>
            @if($loop->first)
            <td rowspan="{{$loop->count}}">{{$scale->U95}}</td>
            @endif
        </tr>
        @endforeach
    </table>

    <h3>2. REPEATABILITY</h3>
    <table class="table-bordered">
        <tr>
            <th>No.</th>
            <th>Muatan (g)</th>
            <th>Penunjukan Rata-rata (g)</th>
            <th>Standar Deviasi (g)</th>
        </tr>
        @foreach($scale->repeatability_scale_calibrations as $repeat)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{round($repeat->weight)}}</td>
            <td>{{round($repeat->average)}}</td>
            <td>{{round($repeat->sd)}}</td>
        </tr>
        @endforeach
    </table>

    <h3>3. ECCENTRICITY</h3>
    <table class="table-transparent">
        <tr>
            <td>
                <table style="border: 1px solid black; border-collapse: collapse; width: 100%; text-align:center;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black; padding: 4px; text-align: center;">Posisi</th>
                            <th style="border: 1px solid black; padding: 4px; text-align: center;">Muatan (g)</th>
                            <th style="border: 1px solid black; padding: 4px; text-align: center;">Penunjukan (g)</th>
                            <th style="border: 1px solid black; padding: 4px; text-align: center;">Koreksi (g)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scale->eccentricity_scale_calibration->actual_eccentricity_scale as $actual)
                        <tr>
                            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ $loop->iteration }}</td>
                            @if($loop->first)
                            <td style="border: 1px solid black; padding: 4px; text-align: center;" rowspan="{{ $loop->count }}">{{ round($scale->eccentricity_scale_calibration->weight) }}</td>
                            @endif
                            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ round($actual->shown) }}</td>
                            <td style="border: 1px solid black; padding: 4px; text-align: center;">{{ round($actual->correction) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td><img src="{{ storage_path('app/mapping.png') }}" alt="mapping"></td>
        </tr>
    </table>
    <p>The uncertainty is taken at a Confidence Level of 95% with a Coverage Factor (k) = {{$scale->k}}.</p>

    <!-- Standard Used -->
    </br>

    <table class="table-transparent" style="float: right; text-align: left; width: 40%;">
        <tr>
            <td>Salatiga, {{ $scale->ttd_date }}</td>
        </tr>
        <tr>
            <td>Technician</td>
        </tr>
        <tr>
            <td> </td>
        </tr>
        <tr>
            <td> </td>
        </tr>
        <tr>
            <td> </td>
        </tr>
        <tr>
            <td> </td>
        </tr>
        <tr>
            <td> </td>
        </tr>
        <tr>
            <td>Fahbi Ahmad Basharo</td>
        </tr>
    </table>

    <!-- Ensure the footer moves to the bottom -->
    <div style="clear: both;"></div>

    <p class="footer"><b>----------- End of Certificate -----------</b></p>

</body>

</html>