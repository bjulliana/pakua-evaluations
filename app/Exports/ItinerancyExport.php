<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItinerancyExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Discipline',
            'Name',
            'Instructor',
            'Current Belt',
            'Current Stripes',
            'Months Practicing',
            'Age',
            'Evaluation Paid',
            'Belt or Patch',
            'Activity 1',
            'Activity 2',
            'Activity 3',
            'Activity 4',
            'Activity 5',
            'Activity 6',
            'New Belt',
            'Received Stripes',
            'Itinerant Notes'
        ];
    }

    public function styles(Worksheet $sheet) {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
