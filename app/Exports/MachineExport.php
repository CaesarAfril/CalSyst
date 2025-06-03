<?php

namespace App\Exports;

use App\Models\Validation_asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MachineExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Validation_asset::with(['department', 'plant', 'machine'])->get();
    }

    public function map($validation_Asset): array
    {
        return [
            $validation_Asset->department->department ?? 'N/A',
            $validation_Asset->plant->plant ?? 'N/A',
            $validation_Asset->location,
            $validation_Asset->machine->machine_name,
            $validation_Asset->detail
        ];
    }

    public function headings(): array
    {
        return ['Departemen', 'Plant', 'Lokasi', 'Nama Mesin', 'Detail'];
    }
}
