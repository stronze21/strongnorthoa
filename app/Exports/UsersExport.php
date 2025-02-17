<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public $columns; // Selected columns
    public $filters; // Applied filters

    public function __construct($columns, $filters)
    {
        $this->columns = $columns;
        $this->filters = $filters;
    }

    // Return the filtered data
    public function collection()
    {
        // Start the query and apply the filters
        $query = User::query();

        // Apply filters (adjust based on your filter logic)
        if (isset($this->filters['search']) && !empty($this->filters['search'])) {
            $query->where('full_name', 'LIKE', '%' . $this->filters['search'] . '%')
                ->orWhere('email', 'LIKE', '%' . $this->filters['search'] . '%');
        }

        if (isset($this->filters['province_id']) && !empty($this->filters['province_id'])) {
            $query->whereHas('municipality', function ($q) {
                $q->where('province_id', $this->filters['province_id']);
            });
        }

        // Add more filters as needed...

        return $query->get();
    }

    // Define the column headings (only for selected columns)
    public function headings(): array
    {
        $headings = [];

        if (in_array('id', $this->columns)) {
            $headings[] = 'ID';
        }
        if (in_array('full_name', $this->columns)) {
            $headings[] = 'Lifechanger';
        }
        if (in_array('date_promoted', $this->columns)) {
            $headings[] = 'Date Promoted';
        }
        // Add more headings based on the selected columns

        return $headings;
    }

    // Map the data for export (only map selected columns)
    public function map($user): array
    {
        $data = [];

        if (in_array('id', $this->columns)) {
            $data[] = $user->id;
        }
        if (in_array('full_name', $this->columns)) {
            $data[] = $user->full_name;
        }
        if (in_array('date_promoted', $this->columns)) {
            $data[] = $user->cur_level ? $user->cur_level->date_promoted->format('Y-m-d') : '';
        }
        // Add more data fields based on the selected columns

        return $data;
    }

    // Define the sheet title
    public function title(): string
    {
        return 'Users Export';
    }
}