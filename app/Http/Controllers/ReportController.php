<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Contest;
use App\Models\CookingShow;
use App\Exports\ShowsExport;
use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Models\OrderAgreement;
use Illuminate\Support\Facades\DB;
use App\Exports\LifechangersExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContestPerformanceExport;

class ReportController extends Controller
{
    /**
     * Display the report dashboard
     */

    /**
     * Display the reports dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get overall statistics
        $totalShows = CookingShow::count();
        $closedShows = CookingShow::where('result', 'Closed')->count();
        $bookedShows = CookingShow::where('result', 'Booked')->count();

        $totalLifechangers = User::role('user')->count();
        $activeLifechangers = $totalLifechangers; // All users considered active for now

        $totalOrders = Order::count();
        $completeOrders = Order::where('oa_status', 'Closed')->count();
        $pendingOrders = $totalOrders - $completeOrders;

        $totalContests = Contest::count();
        $activeContests = Contest::whereDate('end_date', '>=', now())->count();

        // Get monthly statistics
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyShows = CookingShow::whereBetween('date', [$startOfMonth, $endOfMonth])->count();
        $monthlyOrders = Order::whereBetween('oa_date', [$startOfMonth, $endOfMonth])->count();

        // Get sales amount for the month (sum of order prices)
        $monthlySales = Order::whereBetween('oa_date', [$startOfMonth, $endOfMonth])
            ->sum(DB::raw('oa_price_override'));

        // Get recent shows and orders
        $recentShows = CookingShow::orderBy('date', 'desc')->take(5)->get();
        $recentOrders = Order::orderBy('oa_date', 'desc')->take(5)->get();

        // Get chart data for shows by month
        $showsByMonth = $this->getShowsByMonth();
        $ordersByMonth = $this->getOrdersByMonth();

        return view('reports.index', compact(
            'totalShows', 'closedShows', 'bookedShows',
            'totalLifechangers', 'activeLifechangers',
            'totalOrders', 'completeOrders', 'pendingOrders',
            'totalContests', 'activeContests',
            'monthlyShows', 'monthlyOrders', 'monthlySales',
            'recentShows', 'recentOrders',
            'showsByMonth', 'ordersByMonth'
        ));
    }

    /**
     * Generate shows report
     */
    public function showsReport(Request $request)
    {
        $shows = CookingShow::query();

        // Apply filters if provided
        if ($request->has('status') && $request->status != '') {
            $shows->where('result', $request->status);
        }

        if ($request->has('from_date') && $request->from_date != '') {
            $shows->where('date', '>=', Carbon::parse($request->from_date)->startOfDay());
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $shows->where('date', '<=', Carbon::parse($request->to_date)->endOfDay());
        }

        if ($request->has('lifechanger') && $request->lifechanger != '') {
            $shows->where('lifechanger', 'like', '%' . $request->lifechanger . '%');
        }

        // Get results
        $shows = $shows->orderBy('date', 'desc')->paginate(15);

        // Get shows statuses for filter dropdown
        $statuses = [
            'Booked' => 'Booked',
            'Closed' => 'Closed',
            'For Follow Up' => 'For Follow Up',
            'Rescheduled' => 'Rescheduled',
            'Cancelled' => 'Cancelled',
        ];

        return view('reports.shows', compact('shows', 'statuses'));
    }

    /**
     * Generate lifechangers report
     */
    public function lifechangerReport(Request $request)
    {
        $lifechangers = User::role('user')->with(['profile', 'province', 'municipality']);

        // Apply filters if provided
        if ($request->has('level') && $request->level != '') {
            $lifechangers->whereHas('profile', function($query) use ($request) {
                $query->where('current_level', $request->level);
            });
        }

        if ($request->has('region') && $request->region != '') {
            $lifechangers->where('region_id', $request->region);
        }

        // Get results
        $lifechangers = $lifechangers->orderBy('created_at', 'desc')->paginate(15);

        // Get levels for filter dropdown
        $levels = [];
        for ($i = 1; $i <= 5; $i++) {
            $levels[$i] = "Level $i";
        }

        // Get regions for filter dropdown
        $regions = \App\Models\Region::pluck('region_name', 'region_id');

        return view('reports.lifechangers', compact('lifechangers', 'levels', 'regions'));
    }

    /**
     * Generate orders report
     */
    public function ordersReport(Request $request)
    {
        $orders = Order::with(['items', 'payments']);

        // Apply filters if provided
        if ($request->has('status') && $request->status != '') {
            $orders->where('oa_status', $request->status);
        }

        if ($request->has('from_date') && $request->from_date != '') {
            $orders->where('oa_date', '>=', Carbon::parse($request->from_date)->startOfDay());
        }

        if ($request->has('to_date') && $request->to_date != '') {
            $orders->where('oa_date', '<=', Carbon::parse($request->to_date)->endOfDay());
        }

        // Get results
        $orders = $orders->orderBy('oa_date', 'desc')->paginate(15);

        // Get order statuses for filter dropdown
        $statuses = [
            'Complete' => 'Complete',
            'Pending' => 'Pending',
            'Cancelled' => 'Cancelled',
        ];

        return view('reports.orders', compact('orders', 'statuses'));
    }

    /**
     * Generate contest performance report
     */
    public function contestReport(Request $request)
    {
        $contests = Contest::with(['cs']);

        // Apply filters if provided
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'Active') {
                $contests->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            } elseif ($request->status == 'Upcoming') {
                $contests->where('start_date', '>', now());
            } elseif ($request->status == 'Ended') {
                $contests->where('end_date', '<', now());
            }
        }

        // Get results
        $contests = $contests->orderBy('created_at', 'desc')->paginate(15);

        // Get contest statuses for filter dropdown
        $statuses = [
            'Active' => 'Active',
            'Upcoming' => 'Upcoming',
            'Ended' => 'Ended',
        ];

        return view('reports.contests', compact('contests', 'statuses'));
    }

    /**
     * Generate custom report
     */
    public function customReport(Request $request)
    {
        // Available report types
        $reportTypes = [
            'shows' => 'Cooking Shows',
            'lifechangers' => 'Lifechangers',
            'orders' => 'Orders',
            'contests' => 'Contests',
        ];

        // Available export formats
        $exportFormats = [
            'excel' => 'Excel',
            'pdf' => 'PDF',
            'csv' => 'CSV',
        ];

        // Process if form submitted
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'report_type' => 'required|string',
                'format' => 'required|string',
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date',
                'columns' => 'nullable|array',
            ]);

            // Generate and return the report
            return $this->generateReport(
                $validated['report_type'],
                $validated['format'],
                $request->from_date,
                $request->to_date,
                $request->columns ?? []
            );
        }

        return view('reports.custom', compact('reportTypes', 'exportFormats'));
    }

    /**
     * Generate and return the appropriate report
     */
    private function generateReport($type, $format, $fromDate = null, $toDate = null, $columns = [])
    {
        $filename = $type . '_report_' . date('Y-m-d');

        switch ($type) {
            case 'shows':
                $export = new ShowsExport($fromDate, $toDate, $columns);
                break;
            case 'lifechangers':
                $export = new LifechangersExport($fromDate, $toDate, $columns);
                break;
            case 'orders':
                $export = new OrdersExport($fromDate, $toDate, $columns);
                break;
            case 'contests':
                $export = new ContestPerformanceExport($fromDate, $toDate, $columns);
                break;
            default:
                $export = new ShowsExport($fromDate, $toDate, $columns);
                break;
        }

        switch ($format) {
            case 'excel':
                return Excel::download($export, $filename . '.xlsx');
            case 'csv':
                return Excel::download($export, $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
            case 'pdf':
                return Excel::download($export, $filename . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            default:
                return Excel::download($export, $filename . '.xlsx');
        }
    }

    /**
     * Generate dashboard report with summary statistics
     */
    public function dashboardReport()
    {
        // Get counts
        $totalShows = CookingShow::count();
        $bookedShows = CookingShow::where('result', 'Booked')->count();
        $closedShows = CookingShow::where('result', 'Closed')->count();
        $followUpShows = CookingShow::where('result', 'For Follow Up')->count();

        $totalLifechangers = User::role('user')->count();
        $activeLifechangers = User::role('user')->where('deleted_at', null)->count();

        $totalOrders = Order::count();
        $completeOrders = Order::where('oa_status', 'Complete')->count();
        $pendingOrders = Order::where('oa_status', 'Pending')->count();

        $totalContests = Contest::count();
        $activeContests = Contest::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->count();

        // Get recent data
        $recentShows = CookingShow::orderBy('created_at', 'desc')->take(5)->get();
        $recentOrders = Order::orderBy('oa_date', 'desc')->take(5)->get();

        // Calculate monthly stats
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyShows = CookingShow::whereBetween('date', [$startOfMonth, $endOfMonth])->count();
        $monthlyOrders = Order::whereBetween('oa_date', [$startOfMonth, $endOfMonth])->count();

        // Monthly sales amount
        $monthlySales = Order::whereBetween('oa_date', [$startOfMonth, $endOfMonth])
            ->sum('oa_price_override');

        // Get data for charts
        $showsByMonth = $this->getShowsByMonth();
        $ordersByMonth = $this->getOrdersByMonth();

        return view('reports.dashboard', compact(
            'totalShows', 'bookedShows', 'closedShows', 'followUpShows',
            'totalLifechangers', 'activeLifechangers',
            'totalOrders', 'completeOrders', 'pendingOrders',
            'totalContests', 'activeContests',
            'recentShows', 'recentOrders',
            'monthlyShows', 'monthlyOrders', 'monthlySales',
            'showsByMonth', 'ordersByMonth'
        ));
    }

    /**
     * Get shows count by month for the current year
     */
    private function getShowsByMonth()
    {
        $startOfYear = Carbon::now()->startOfYear();
        $months = [];
        $counts = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $startOfYear->copy()->addMonths($i);
            $months[] = $month->format('M');

            $counts[] = CookingShow::whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->count();
        }

        return [
            'months' => $months,
            'counts' => $counts
        ];
    }

    /**
     * Get orders count by month for the current year
     */
    private function getOrdersByMonth()
    {
        $startOfYear = Carbon::now()->startOfYear();
        $months = [];
        $counts = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $startOfYear->copy()->addMonths($i);
            $months[] = $month->format('M');

            $counts[] = Order::whereYear('oa_date', $month->year)
                ->whereMonth('oa_date', $month->month)
                ->count();
        }

        return [
            'months' => $months,
            'counts' => $counts
        ];
    }
}