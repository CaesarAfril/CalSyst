<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class TempCalibrationExport implements WithEvents, WithStyles
{
    private $temperature;

    public function __construct($temperature)
    {
        $this->temperature = $temperature;
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A12:M12')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '000000']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);

        // Borders for entire table
        $sheet->getStyle('A12:M100')->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // === HEADER ROWS ===
                $sheet->mergeCells('A12:A14'); // Set Suhu
                $sheet->mergeCells('B12:I12'); // Pengulangan Pengukuran
                $sheet->mergeCells('J12:J14'); // Rata-rata
                $sheet->mergeCells('K12:K14'); // SD
                $sheet->mergeCells('L12:L14'); // Koreksi
                $sheet->mergeCells('M12:M14'); // Koreksi

                // Row 2
                $sheet->mergeCells('A12:A13'); // Set Suhu (°C)
                $sheet->mergeCells('B13:I13'); // Sensor row

                // Row 3: Sensor Labels
                $sheet->setCellValue('A1', 'Nama Alat :');
                $sheet->setCellValue('B1', $this->temperature->asset->merk . ' ' . $this->temperature->asset->type . ' ' . $this->temperature->asset->series_number);
                $sheet->setCellValue('A3', 'Rata-rata SD UUT : ');
                $sheet->setCellValue('B3', $this->temperature->avg_stdev_uut);
                $sheet->setCellValue('A4', 'U1 :');
                $sheet->setCellValue('B4', $this->temperature->u1);
                $sheet->setCellValue('A5', 'U2 :');
                $sheet->setCellValue('B5', $this->temperature->u2);
                $sheet->setCellValue('A6', 'U3 :');
                $sheet->setCellValue('B6', $this->temperature->u3);
                $sheet->setCellValue('A7', 'UC :');
                $sheet->setCellValue('B7', $this->temperature->uc);
                $sheet->setCellValue('A8', 'Veff :');
                $sheet->setCellValue('A9', 'K :');
                $sheet->setCellValue('B9', $this->temperature->k);
                $sheet->setCellValue('A10', 'U95 :');
                $sheet->setCellValue('B10', $this->temperature->u95);

                $sheet->setCellValue('A12', 'Set Suhu');
                $sheet->setCellValue('B12', 'Pengulangan Pengukuran');
                $sheet->setCellvalue('J12', 'Rata-rata');
                $sheet->setCellValue('K12', 'SD');
                $sheet->setCellValue('L12', 'Koreksi');
                $sheet->setCellValue('M12', 'U4');
                $sheet->setCellValue('B13', '(°C)');
                $sheet->setCellValue('B14', 'Sensor');
                $sheet->setCellValue('C14', '1');
                $sheet->setCellValue('D14', '2');
                $sheet->setCellValue('E14', '3');
                $sheet->setCellValue('F14', '4');
                $sheet->setCellValue('G14', '5');
                $sheet->setCellValue('H14', '6');
                $sheet->setCellValue('I14', '7');
                $sheet->setCellValue('J14', 'Avg');
                $sheet->setCellValue('K14', 'SD');
                $sheet->setCellValue('L14', 'Correction');


                // Style Alignment
                $sheet->getStyle('A12:M14')->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'font' => ['bold' => true]
                ]);

                // === DATA ROWS ===
                $row = 15; // Start data row
                foreach ($this->temperature->actual_temps as $actual) {
                    // Set Temp
                    $sheet->mergeCells("A$row:A" . ($row + 1));
                    $sheet->setCellValue("A$row", $actual->set_temp);

                    // PRT Row
                    $sheet->setCellValue("B$row", "PRT");
                    $sheet->setCellValue("C$row", $actual->standar1);
                    $sheet->setCellValue("D$row", $actual->standar2);
                    $sheet->setCellValue("E$row", $actual->standar3);
                    $sheet->setCellValue("F$row", $actual->standar4);
                    $sheet->setCellValue("G$row", $actual->standar5);
                    $sheet->setCellValue("H$row", $actual->standar6);
                    $sheet->setCellValue("I$row", $actual->standar7);
                    $sheet->setCellValue("J$row", $actual->avgprt);
                    $sheet->setCellValue("K$row", $actual->stdevprt);

                    // Merge Correction
                    $sheet->mergeCells("L$row:L" . ($row + 1));
                    $sheet->setCellValue("L$row", $actual->correction);

                    $sheet->mergeCells("M$row:M" . ($row + 1));
                    $sheet->setCellValue("M$row", $actual->uprt);
                    $row++; // Move to next row

                    // UUT Row
                    $sheet->setCellValue("B$row", "UUT");
                    $sheet->setCellValue("C$row", $actual->aktual1);
                    $sheet->setCellValue("D$row", $actual->aktual2);
                    $sheet->setCellValue("E$row", $actual->aktual3);
                    $sheet->setCellValue("F$row", $actual->aktual4);
                    $sheet->setCellValue("G$row", $actual->aktual5);
                    $sheet->setCellValue("H$row", $actual->aktual6);
                    $sheet->setCellValue("I$row", $actual->aktual7);
                    $sheet->setCellValue("J$row", $actual->avguut);
                    $sheet->setCellValue("K$row", $actual->stdevuut);

                    $row++; // Move to next set temp
                }
            }
        ];
    }
}
