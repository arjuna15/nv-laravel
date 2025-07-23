<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    protected Collection $data;

    public function __construct(array $data)
    {
        $this->data = collect($data); // mengubah array ke Collection
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'No Booking',
            'Nama Tamu',
            'Tanggal',
            'Total',
            'Uang Masuk',
            'Sisa',
            'Pelunasan',
            'Catatan',
            'No HP',
            'Status',
        ];
    }
}
