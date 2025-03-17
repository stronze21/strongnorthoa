<?php

namespace App\Exports;

use App\Models\CookingShow;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ShowsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $fromDate;
    protected $toDate;
    protected $columns;

    public function __construct($fromDate = null, $toDate = null, $columns = [])
    {
        $this->fromDate = $fromDate ? Carbon::parse($fromDate) : null;
        $this->toDate = $toDate ? Carbon::parse($toDate) : null;
        $this->columns = !empty($columns) ? $columns : [
            'reference', 'date', 'time', 'host', 'address', 'city_town', 'province',
            'contact_no', 'lifechanger', 'presenter', 'result'
        ];
    }

    public function query()
    {
        $shows = CookingShow::query();

        if ($this->fromDate) {
            $shows->where('date', '>=', $this->fromDate->startOfDay());
        }

        if ($this->toDate) {
            $shows->where('date', '<=', $this->toDate->endOfDay());
        }

        return $shows->orderBy('date', 'desc');
    }

    public function headings(): array
    {
        $headings = [];

        $allHeadings = [
            'reference' => 'Reference',
            'date' => 'Date',
            'time' => 'Time',
            'host' => 'Host Name',
            'host_lastname' => 'Host Last Name',
            'host_surename' => 'Host Surname',
            'address' => 'Address',
            'address_2' => 'Address Line 2',
            'city_town' => 'City/Town',
            'province' => 'Province',
            'postal_code' => 'Postal Code',
            'contact_no' => 'Contact Number',
            'host_email' => 'Host Email',
            'lifechanger' => 'Lifechanger',
            'presenter' => 'Presenter',
            'partner_id' => 'Partner ID',
            'result' => 'Status',
            'notes' => 'Notes',
            'created_at' => 'Date Created'
        ];

        foreach ($this->columns as $column) {
            if (isset($allHeadings[$column])) {
                $headings[] = $allHeadings[$column];
            }
        }

        return $headings;
    }

    public function map($show): array
    {
        $row = [];

        foreach ($this->columns as $column) {
            switch ($column) {
                case 'reference':
                    $row[] = $show->showReferenceAttribute ?? 'N/A';
                    break;
                case 'date':
                    $row[] = $show->date ? Carbon::parse($show->date)->format('M j, Y') : 'N/A';
                    break;
                case 'time':
                    $row[] = $show->time ? Carbon::parse($show->time)->format('g:i A') : 'N/A';
                    break;
                case 'created_at':
                    $row[] = $show->created_at ? $show->created_at->format('M j, Y g:i A') : 'N/A';
                    break;
                default:
                    $row[] = $show->$column ?? 'N/A';
                    break;
            }
        }

        return $row;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'],
            ],
        ]);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Cooking Shows Report';
    }
}
