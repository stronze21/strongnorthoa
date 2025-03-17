<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LifechangersExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $fromDate;
    protected $toDate;
    protected $columns;

    public function __construct($fromDate = null, $toDate = null, $columns = [])
    {
        $this->fromDate = $fromDate ? Carbon::parse($fromDate) : null;
        $this->toDate = $toDate ? Carbon::parse($toDate) : null;
        $this->columns = !empty($columns) ? $columns : [
            'user_id', 'full_name', 'email', 'contact_no', 'address', 'region', 'province',
            'municipality', 'current_level', 'birth_date', 'sign_up_date'
        ];
    }

    public function query()
    {
        $lifechangers = User::role('user')
            ->with(['profile', 'region', 'province', 'municipality']);

        if ($this->fromDate) {
            $lifechangers->whereHas('profile', function($query) {
                $query->where('sign_up_date', '>=', $this->fromDate->startOfDay());
            });
        }

        if ($this->toDate) {
            $lifechangers->whereHas('profile', function($query) {
                $query->where('sign_up_date', '<=', $this->toDate->endOfDay());
            });
        }

        return $lifechangers->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        $headings = [];

        $allHeadings = [
            'user_id' => 'ID',
            'full_name' => 'Full Name',
            'f_name' => 'First Name',
            'l_name' => 'Last Name',
            'm_name' => 'Middle Name',
            'email' => 'Email',
            'contact_no' => 'Contact Number',
            'address' => 'Address',
            'region' => 'Region',
            'province' => 'Province',
            'municipality' => 'Municipality',
            'birth_date' => 'Birth Date',
            'current_level' => 'Current Level',
            'sign_up_date' => 'Sign Up Date',
            'team_leader' => 'Team Leader',
            'team_builder' => 'Team Builder',
            'distributor' => 'Distributor',
            'created_at' => 'Date Created'
        ];

        foreach ($this->columns as $column) {
            if (isset($allHeadings[$column])) {
                $headings[] = $allHeadings[$column];
            }
        }

        return $headings;
    }

    public function map($user): array
    {
        $row = [];

        foreach ($this->columns as $column) {
            switch ($column) {
                case 'user_id':
                    $row[] = $user->user_id;
                    break;
                case 'full_name':
                    $row[] = $user->fullname();
                    break;
                case 'region':
                    $row[] = $user->region ? $user->region->region_name : 'N/A';
                    break;
                case 'province':
                    $row[] = $user->province ? $user->province->province_name : 'N/A';
                    break;
                case 'municipality':
                    $row[] = $user->municipality ? $user->municipality->municipality_name : 'N/A';
                    break;
                case 'current_level':
                    $row[] = $user->profile ? ('Level ' . $user->profile->current_level) : 'N/A';
                    break;
                case 'birth_date':
                    $row[] = $user->birth_date ? Carbon::parse($user->birth_date)->format('M j, Y') : 'N/A';
                    break;
                case 'sign_up_date':
                    $row[] = $user->profile && $user->profile->sign_up_date ?
                        Carbon::parse($user->profile->sign_up_date)->format('M j, Y') : 'N/A';
                    break;
                case 'team_leader':
                    $row[] = $user->profile && $user->profile->leader ?
                        $user->profile->leader->fullname() : 'N/A';
                    break;
                case 'team_builder':
                    $row[] = $user->profile && $user->profile->builder ?
                        $user->profile->builder->fullname() : 'N/A';
                    break;
                case 'distributor':
                    $row[] = $user->profile && $user->profile->distrib ?
                        $user->profile->distrib->fullname() : 'N/A';
                    break;
                case 'created_at':
                    $row[] = $user->created_at ? $user->created_at->format('M j, Y') : 'N/A';
                    break;
                default:
                    $row[] = $user->$column ?? 'N/A';
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
        return 'Lifechangers Report';
    }
}
