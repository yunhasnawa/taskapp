<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskOverviewController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.tasks.index', [
            'tasks' => Task::with('user', 'category')
                ->filter($request->only('search', 'status', 'priority'))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'users' => User::withCount('tasks')->orderBy('name')->get(),
        ]);
    }
}
