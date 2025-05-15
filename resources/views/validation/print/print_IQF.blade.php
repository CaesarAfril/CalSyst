<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Validasi IQF</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
        }

        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 1px;
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
            padding: 1px;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        h2, h3, h4, h5 {
            margin-bottom: unset !important;
            padding-bottom: unset !important;
        }

        ul, ol {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:1px;
        overflow:hidden;padding:2px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;
        font-weight:normal;overflow:hidden;padding:2px;word-break:normal;}
        .tg .tg-0lax{text-align:left;vertical-align:top}

        /* CSS untuk cetak PDF */
        .header {
            position: fixed;
            top: -60px;
            left: 0;
            width: 100%;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        @page {
            margin-top: 100px;
            size: 210mm 330mm;
            margin-header: 10mm;
        }

        body {
            margin-top: 30px;
        }

        p {
            line-height: 1.2 !important;
        }
    </style>
</head>
<body>
    {{-- header --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 30%; vertical-align: middle;">
                    <table style="border: none; border-collapse: collapse;">
                        <tr>
                            <td style="vertical-align: middle; width: 50px;">
                                @php
                                    $path = public_path('storage/image/logo.png');
                                    if(file_exists($path)) {
                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                        $data = file_get_contents($path);
                                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    }
                                @endphp
                                <img src="{{ $base64 ?? '' }}" alt="Logo" style="width: 50px;">
                            </td>
                            <td style="vertical-align: middle; padding-left: 10px;">
                                <div style="font-size: 9px; font-weight: bold; line-height: 1.2;">
                                    CHAROEN<br>POKPHAND<br>INDONESIA PT.<br>Food Division
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <h2 style="margin-left: -12rem; text-transform: uppercase;">
                        HASIL VALIDASI MESIN<br>
                    </h2>
                </td>
            </tr>
        </table>
    </div>

    <div>
        content
    </div>
</body>
</html>