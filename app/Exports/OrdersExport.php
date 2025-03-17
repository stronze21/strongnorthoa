<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $fromDate;
    protected $toDate;
    protected $columns;

    public function __construct($fromDate = null, $toDate = null, $columns = [])
    {
        $this->fromDate = $fromDate ? Carbon::parse($fromDate) : null;
        $this->toDate = $toDate ? Carbon::parse($toDate) : null;
        $this->columns = !empty($columns) ? $columns : [
            'oa_number', 'oa_date', 'oa_client', 'oa_address', 'oa_contact',
            'oa_consultant', 'oa_presenter', 'total_amount', 'paid_amount', 'payment_status', 'oa_status'
        ];
    }

    public function query()
    {
        $orders = Order::with(['items', 'payments']);

        if ($this->fromDate) {
            $orders->where('oa_date', '>=', $this->fromDate->startOfDay());
        }

        if ($this->toDate) {
            $orders->where('oa_date', '<=', $this->toDate->endOfDay());
        }

        return $orders->orderBy('oa_date', 'desc');
    }

    public function headings(): array
    {
        $headings = [];

        $allHeadings = [
            'oa_id' => 'Order ID',
            'oa_number' => 'Order Number',
            'oa_date' => 'Order Date',
            'oa_client' => 'Client',
            'oa_address' => 'Address',
            'oa_contact' => 'Contact',
            'oa_consultant' => 'Consultant',
            'oa_associate' => 'Associate',
            'oa_presenter' => 'Presenter',
            'oa_team_builder' => 'Team Builder',
            'oa_distributor' => 'Distributor',
            'total_amount' => 'Total Amount',
            'paid_amount' => 'Paid Amount',
            'payment_status' => 'Payment Status',
            'oa_status' => 'Order Status',
            'item_count' => 'Number of Items'
        ];

        foreach ($this->columns as $column) {
            if (isset($allHeadings[$column])) {
                $headings[] = $allHeadings[$column];
            }
        }

        return $headings;
    }

    public function map($order): array
    {
        $row = [];

        foreach ($this->columns as $column) {
            switch ($column) {
                case 'oa_date':
                    $row[] = $order->oa_date ? Carbon::parse($order->oa_date)->format('M j, Y') : 'N/A';
                    break;
                case 'total_amount':
                    $total = $order->oa_price_override ?:
                        ($order->items->sum('item_total') + ($order->oa_price_diff ?: 0));
                    $row[] = number_format($total, 2);
                    break;
                case 'paid_amount':
                    $row[] = number_format($order->payments->sum('amount'), 2);
                    break;
                case 'payment_status':
                    $percentage = $order->percentage();
                    if ($percentage == 100) {
                        $row[] = 'Fully Paid';
                    } elseif ($percentage > 0) {
                        $row[] = 'Partially Paid (' . $percentage . '%)';
                    } else {
                        $row[] = 'Unpaid';
                    }
                    break;
                case 'item_count':
                    $row[] = $order->items->count();
                    break;
                default:
                    $row[] = $order->$column ?? 'N/A';
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
        return 'Orders Report';
    }
}