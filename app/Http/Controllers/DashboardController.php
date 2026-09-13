<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $tasks = $request->user()->tasks();

        return view('dashboard', [
            'total'      => (clone $tasks)->count(),
            'belum'      => (clone $tasks)->where('status', 'belum')->count(),
            'dikerjakan' => (clone $tasks)->where('status', 'dikerjakan')->count(),
            'selesai'    => (clone $tasks)->where('status', 'selesai')->count(),
            'terlambat'  => (clone $tasks)->where('status', '!=', 'selesai')
                ->whereNotNull('due_date')
                ->orderBy('due_date')
                ->take(5)
                ->get(),
        ]);
    }
}
