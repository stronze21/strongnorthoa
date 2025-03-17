<?php

namespace App\Services;

use App\Models\Contest;
use App\Models\CookingShow;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportGenerator
{
    /**
     * Generate a report about cooking shows
     *
     * @param array $filters
     * @return Collection
     */
    public function generateShowsReport(array $filters = []): Collection
    {
        $query = CookingShow::query();

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('result', $filters['status']);
        }

        if (isset($filters['from_date']) && $filters['from_date']) {
            $query->where('date', '>=', Carbon::parse($filters['from_date'])->startOfDay());
        }

        if (isset($filters['to_date']) && $filters['to_date']) {
            $query->where('date', '<=', Carbon::parse($filters['to_date'])->endOfDay());
        }

        if (isset($filters['lifechanger']) && $filters['lifechanger']) {
            $query->where('lifechanger', 'like', '%' . $filters['lifechanger'] . '%');
        }

        return $query->orderBy('date', 'desc')->get();
    }

    /**
     * Generate a report about lifechangers
     *
     * @param array $filters
     * @return Collection
     */
    public function generateLifechangersReport(array $filters = []): Collection
    {
        $query = User::role('user')->with(['profile', 'region', 'province']);

        // Apply filters
        if (isset($filters['level']) && $filters['level']) {
            $query->whereHas('profile', function($query) use ($filters) {
                $query->where('current_level', $filters['level']);
            });
        }

        if (isset($filters['region']) && $filters['region']) {
            $query->where('region_id', $filters['region']);
        }

        if (isset($filters['from_date']) && $filters['from_date']) {
            $query->whereHas('profile', function($query) use ($filters) {
                $query->where('sign_up_date', '>=', Carbon::parse($filters['from_date'])->startOfDay());
            });
        }

        if (isset($filters['to_date']) && $filters['to_date']) {
            $query->whereHas('profile', function($query) use ($filters) {
                $query->where('sign_up_date', '<=', Carbon::parse($filters['to_date'])->endOfDay());
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Generate a report about orders
     *
     * @param array $filters
     * @return Collection
     */
    public function generateOrdersReport(array $filters = []): Collection
    {
        $query = Order::with(['items', 'payments']);

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('oa_status', $filters['status']);
        }

        if (isset($filters['from_date']) && $filters['from_date']) {
            $query->where('oa_date', '>=', Carbon::parse($filters['from_date'])->startOfDay());
        }

        if (isset($filters['to_date']) && $filters['to_date']) {
            $query->where('oa_date', '<=', Carbon::parse($filters['to_date'])->endOfDay());
        }

        return $query->orderBy('oa_date', 'desc')->get();
    }

    /**
     * Generate a report about contests
     *
     * @param array $filters
     * @return Collection
     */
    public function generateContestsReport(array $filters = []): Collection
    {
        $query = Contest::with(['cs', 'sspl']);

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            if ($filters['status'] == 'Active') {
                $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            } elseif ($filters['status'] == 'Upcoming') {
                $query->where('start_date', '>', now());
            } elseif ($filters['status'] == 'Ended') {
                $query->where('end_date', '<', now());
            }
        }

        if (isset($filters['from_date']) && $filters['from_date']) {
            $query->where('start_date', '>=', Carbon::parse($filters['from_date'])->startOfDay());
        }

        if (isset($filters['to_date']) && $filters['to_date']) {
            $query->where('end_date', '<=', Carbon::parse($filters['to_date'])->endOfDay());
        }

        return $query->orderBy('start_date', 'desc')->get();
    }

    /**
     * Generate performance statistics
     *
     * @param string $period 'daily', 'weekly', 'monthly', 'yearly'
     * @return array
     */
    public function generatePerformanceStats(string $period = 'monthly'): array
    {
        $now = Carbon::now();
        $stats = [];

        // Determine date range based on period
        switch ($period) {
            case 'daily':
                $startDate = $now->copy()->subDays(30);
                $interval = 'day';
                break;
            case 'weekly':
                $startDate = $now->copy()->subWeeks(12);
                $interval = 'week';
                break;
            case 'yearly':
                $startDate = $now->copy()->subYears(5);
                $interval = 'year';
                break;
            case 'monthly':
            default:
                $startDate = $now->copy()->subMonths(12);
                $interval = 'month';
                break;
        }

        // Get shows count
        $stats['shows'] = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $now) {
            $periodStart = $currentDate->copy()->startOf($interval);
            $periodEnd = $currentDate->copy()->endOf($interval);
            $label = $currentDate->format($interval === 'day' ? 'M d' : ($interval === 'week' ? '\WW' : ($interval === 'year' ? 'Y' : 'M Y')));

            $stats['shows'][] = [
                'label' => $label,
                'count' => CookingShow::whereBetween('date', [$periodStart, $periodEnd])->count(),
                'booked' => CookingShow::where('result', 'Booked')->whereBetween('date', [$periodStart, $periodEnd])->count(),
                'closed' => CookingShow::where('result', 'Closed')->whereBetween('date', [$periodStart, $periodEnd])->count(),
            ];

            // Increment date
            $currentDate->add($interval, 1);
        }

        // Get orders count and sales total
        $stats['orders'] = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $now) {
            $periodStart = $currentDate->copy()->startOf($interval);
            $periodEnd = $currentDate->copy()->endOf($interval);
            $label = $currentDate->format($interval === 'day' ? 'M d' : ($interval === 'week' ? '\WW' : ($interval === 'year' ? 'Y' : 'M Y')));

            $ordersInPeriod = Order::whereBetween('oa_date', [$periodStart, $periodEnd])->get();
            $orderCount = $ordersInPeriod->count();

            // Calculate sales total
            $salesTotal = 0;
            foreach ($ordersInPeriod as $order) {
                $salesTotal += $order->oa_price_override ?:
                    ($order->items->sum('item_total') + ($order->oa_price_diff ?: 0));
            }

            $stats['orders'][] = [
                'label' => $label,
                'count' => $orderCount,
                'sales' => $salesTotal,
            ];

            // Increment date
            $currentDate->add($interval, 1);
        }

        return $stats;
    }
}
