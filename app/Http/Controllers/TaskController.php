<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\Tasks\IndexTaskRequest;
use App\Models\Task;
use App\Http\Requests\Tasks\StoreTaskRequest;
use App\Http\Requests\Tasks\UpdateTaskRequest;
use App\Models\Project;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  IndexTaskRequest $request
     * @param  Project $project
     * @return \Inertia\Response
     */
    public function index(IndexTaskRequest $request, Project $project)
    {
        $filters = $request->safe()->filters ?? [];

        foreach(TaskStatus::values() as $status)
        {
            $project->loadCount([
                'tasks as tasks_' . Str::snake($status) . '_count' => fn($query) => $query->whereStatus($status)
            ]);
        }

        return Inertia::render('Tasks', [
            'tasks'     => $project->tasks()->filters($filters)->paginate(),
            'project'   => $project,
            'filters'   => $filters
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Tasks\StoreTaskRequest  $request
     * @param  Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        ($task = $project->tasks()->create($request->validated()))
            ? session()->flash('success', __('crud.create.success', [ 'item' => 'task' ]))
            : session()->flash('error', __('crud.create.error', [ 'item' => 'task' ]));

        return redirect()->back()->with(['returned_data' => ['task' => $task]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Tasks\UpdateTaskRequest  $request
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Inertia\Response
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $task->update($request->validated())
            ? session()->flash('success', __('crud.update.success', [ 'item' => 'task' ]))
            : session()->flash('error', __('crud.update.error', [ 'item' => 'task' ]));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @param  \App\Models\Task  $task
     * @return \Inertia\Response
     */
    public function destroy(Project $project,Task $task)
    {
        $task->delete()
            ? session()->flash('success', __('crud.delete.success', [ 'item' => 'task' ]))
            : session()->flash('error', __('crud.delete.error', [ 'item' => 'task' ]));

        return redirect()->back();
    }
}
