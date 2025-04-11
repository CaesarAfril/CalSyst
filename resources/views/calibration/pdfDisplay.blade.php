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
                {{$display->certificate_number}}
            </td>
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
        </tr>
    </table>
    </br>
    <table class="table-transparent">
        <tr>
            <td style="width: 16%;">
                Instrument Name
            </td>
            <td style="width: 5%;">
                :
            </td>
            <td>{{$display->asset->category->category}}</td>
            <td></td>
            <td style="width: 16%;">
                Calibration Date
            </td>
            <td style="width: 5%;">
                :
            </td>
            <td>{{$display->calibration_date}}</td>
        </tr>
        <tr>
            <td>
                Manufacturer
            </td>
            <td>
                :
            </td>
            <td>
                {{$display->asset->merk}}
            </td>
            <td></td>
            <td colspan="3">
                Environmental Condition
            </td>
        </tr>
        <tr>
            <td>
                Model/Type
            </td>
            <td>
                :
            </td>
            <td>
                {{$display->asset->type}}
            </td>
            <td></td>
            <td colspan="3" style="text-align: center;">
                Initial
            </td>
        </tr>
        <tr>
            <td>
                Serial Number
            </td>
            <td>
                :
            </td>
            <td>
                {{$display->asset->series_number}}
            </td>
            <td></td>
            <td style="text-align: center;">
                T (°C) : {{$display->initial_temp}}°C
            </td>
            <td></td>
            <td style="text-align: center;">
                RH (%) : {{$display->initial_rh}}%
            </td>
        </tr>
        <tr>
            <td>
                Capacity
            </td>
            <td>
                :
            </td>
            <td>
                {{$display->asset->capacity}}
            </td>
            <td></td>
            <td colspan="3" style="text-align: center;">
                Final
            </td>
        </tr>
        <tr>
            <td>
                Readability
            </td>
            <td>
                :
            </td>
            <td>
                {{$display->asset->resolution}}°C
            </td>
            <td></td>
            <td style="text-align: center;">
                T (°C) : {{$display->final_temp}}°C
            </td>
            <td></td>
            <td style="text-align: center;">
                RH (%) : {{$display->final_rh}}%
            </td>
        </tr>
    </table>
    <br>

    <!-- Calibration Report -->
    <h3>Calibration Report :</h3>
    <table class="table-bordered">
        <tr>
            <th rowspan="2">Media Set (°C)</th>
            <th>Standard Indicator</th>
            <th>Instrument Indicator</th>
            <th>Correction</th>
        </tr>
        <tr>
            <th>(°C)</th>
            <th>(°C)</th>
            <th>(°C)</th>
        </tr>
        @foreach($display->actual_displays as $actual)
        <tr>
            <td>{{$actual->set_temp}}</td>
            <td>{{$actual->avgprt}}</td>
            <td>{{$actual->avguut}}</td>
            <td>{{$actual->correction}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2"><b>uncertainty(U95%)</b></td>
            <td colspan="2"><b>{{$display->u95}}</b></td>
        </tr>
    </table>

    <p>The uncertainty is taken at a Confidence Level of 95% with a Coverage Factor (k) = {{$display->k}}.</p>

    <!-- Standard Used -->
    <h3>Standard Used</h3>
    <table class="table-transparent">
        <tr>
            <td>Name</td>
            <td>Merk/Type</td>
            <td>Serial Number</td>
            <td>Traceable to SI</td>
        </tr>
        <tr>
            <td>Digital Thermometer</td>
            <td>Testo/ 106</td>
            <td>83817881/0422</td>
            <td> LK-281-IDN</td>
        </tr>
        <tr>
            <td>Waterbath</td>
            <td>Huber KISS E</td>
            <td>S517015</td>
            <td>LK-280-IDN</td>
        </tr>
    </table>
    </br>

    <table class="table-transparent" style="float: right; text-align: left; width: 40%;">
        <tr>
            <td>Salatiga, {{ $display->ttd_date }}</td>
        </tr>
        <tr>
            <td>Technician</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td></td>
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