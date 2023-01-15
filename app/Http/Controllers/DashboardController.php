<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'tasks_statuses'    => Task::query()
                                        ->select('status', DB::raw('count(*) as count'))
                                        ->groupBy('status')
                                        ->get(),
            'tasks_priorities'  => Task::query()
                                        ->select('priority', DB::raw('count(*) as count'))
                                        ->whereNotIn('status', [TaskStatus::DONE, TaskStatus::CANCELED])
                                        ->groupBy('priority')
                                        ->get(),
            'tasks_deadlines'   => Task::query()
                                        ->selectRaw('DATE(deadline) as end_date, count(*) as count')
                                        ->whereBetween('deadline', [today(), today()->addWeek()->endOfDay()])
                                        ->groupByRaw('DATE(deadline)')
                                        ->orderBy('deadline')
                                        ->get()->toArray()
        ]);
    }
}
