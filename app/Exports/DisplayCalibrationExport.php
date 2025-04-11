<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class DisplayCalibrationExport implements WithEvents, WithStyles
{
    private $display;

    public function __construct($display)
    {
        $this->display = $display;
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A12:K12')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => '000000']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ]);

        // Borders for entire table
        $sheet->getStyle('A12:K100')->applyFromArray([
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
                $sheet->mergeCells('B12:G12'); // Pengulangan Pengukuran
                $sheet->mergeCells('H12:H14'); // Rata-rata
                $sheet->mergeCells('I12:I14'); // SD
                $sheet->mergeCells('J12:J14'); // Koreksi
                $sheet->mergeCells('K12:K14');

                // Row 2
                $sheet->mergeCells('A12:G13'); // Set Suhu (°C)
                $sheet->mergeCells('B13:I13'); // Sensor row

                // Row 3: Sensor Labels
                $sheet->setCellValue('A1', 'Nama Alat :');
                $sheet->setCellValue('B1', $this->display->asset->merk . ' ' . $this->display->asset->type . ' ' . $this->display->asset->series_number);
                $sheet->setCellValue('A3', 'Rata-rata SD UUT : ');
                $sheet->setCellValue('B3', $this->display->avg_stdev_uut);
                $sheet->setCellValue('A4', 'U1 :');
                $sheet->setCellValue('B4', $this->display->u1);
                $sheet->setCellValue('A5', 'U2 :');
                $sheet->setCellValue('B5', $this->display->u2);
                $sheet->setCellValue('A6', 'U3 :');
                $sheet->setCellValue('B6', $this->display->u3);
                $sheet->setCellValue('A7', 'UC :');
                $sheet->setCellValue('B7', $this->display->uc);
                $sheet->setCellValue('A8', 'Veff :');
                $sheet->setCellValue('A9', 'K :');
                $sheet->setCellValue('B9', $this->display->k);
                $sheet->setCellValue('A10', 'U95 :');
                $sheet->setCellValue('B10', $this->display->u95);

                $sheet->setCellValue('A12', 'Set Suhu');
                $sheet->setCellValue('B12', 'Pengulangan Pengukuran');
                $sheet->setCellvalue('H12', 'Rata-rata');
                $sheet->setCellValue('I12', 'SD');
                $sheet->setCellValue('J12', 'Koreksi');
                $sheet->setCellValue('K12', 'U4');
                $sheet->setCellValue('B13', '(°C)');
                $sheet->setCellValue('B14', 'Sensor');
                $sheet->setCellValue('C14', '1');
                $sheet->setCellValue('D14', '2');
                $sheet->setCellValue('E14', '3');
                $sheet->setCellValue('F14', '4');
                $sheet->setCellValue('G14', '5');
                $sheet->setCellValue('H14', 'Avg');
                $sheet->setCellValue('I14', 'SD');
                $sheet->setCellValue('J14', 'Correction');


                // Style Alignment
                $sheet->getStyle('A12:M14')->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'font' => ['bold' => true]
                ]);

                // === DATA ROWS ===
                $row = 15; // Start data row
                foreach ($this->display->actual_displays as $actual) {
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
                    $sheet->setCellValue("H$row", $actual->avgprt);
                    $sheet->setCellValue("I$row", $actual->stdevprt);

                    // Merge Correction
                    $sheet->mergeCells("J$row:J" . ($row + 1));
                    $sheet->setCellValue("J$row", $actual->correction);

                    $sheet->mergeCells("K$row:K" . ($row + 1));
                    $sheet->setCellValue("K$row", $actual->uprt);
                    $row++;

                    $sheet->setCellValue("B$row", "UUT");
                    $sheet->setCellValue("C$row", $actual->aktual1);
                    $sheet->setCellValue("D$row", $actual->aktual2);
                    $sheet->setCellValue("E$row", $actual->aktual3);
                    $sheet->setCellValue("F$row", $actual->aktual4);
                    $sheet->setCellValue("G$row", $actual->aktual5);
                    $sheet->setCellValue("H$row", $actual->avguut);
                    $sheet->setCellValue("I$row", $actual->stdevuut);

                    $row++;
                }
            }
        ];
    }
}
