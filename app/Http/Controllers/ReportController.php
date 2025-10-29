<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function daily(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));

        $dailyReports = Sale::whereDate('date', $date)
            ->selectRaw('name, SUM(quantity) as sold_quantity, SUM(total) as total_price')
            ->groupBy('name')
            ->get();

        $dailyTotal = $dailyReports->sum('total_price');

        return view('reports.index', [
            'dailyReports' => $dailyReports,
            'dailyTotal' => $dailyTotal,
            'selectedDate' => $date
        ]);
    }

    public function monthly(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));

        $monthlyReports = Sale::whereBetween('date', [$start, $end])
            ->selectRaw('name, SUM(quantity) as sold_quantity, SUM(total) as total_price')
            ->groupBy('name')
            ->get();

        $monthlySummary = Sale::whereBetween('date', [$start, $end])
            ->selectRaw('DAY(date) as day, COUNT(DISTINCT id) as count')
            ->groupBy('day')
            ->pluck('count', 'day');

        $monthlyTotal = $monthlyReports->sum('total_price');

        return view('reports.index', [
            'monthlyReports' => $monthlyReports,
            'monthlySummary' => $monthlySummary,
            'monthlyTotal' => $monthlyTotal,
            'selectedMonth' => $month
        ]);
    }


}
