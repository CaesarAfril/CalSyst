<?php

namespace App\Exports;

use App\Models\Assets;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Assets::with(['plant', 'department', 'category'])->get();
    }

    public function map($assets): array
    {
        return [
            $assets->plant->plant ?? 'N/A',
            $assets->department->department ?? 'N/A',
            $assets->location,
            $assets->category->category ?? 'N/A',
            $assets->merk,
            $assets->type,
            $assets->series_number,
            $assets->capacity,
            $assets->range,
            $assets->resolution,
            $assets->correction,
            $assets->uncertainty,
            $assets->standard,
            $assets->expired_date->format('d-m-Y')
        ];
    }

    public function headings(): array
    {
        return ['Plant', 'Departemen', 'Lokasi', 'Kategori', 'Merk', 'Tipe', 'Nomor Seri', 'Kapasitas', 'Range', 'Resolusi', 'Koreksi', 'Ketidakpastian', 'standar', 'Expired'];
    }
}
