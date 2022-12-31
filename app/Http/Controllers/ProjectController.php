<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Requests\Projects\IndexProjectRequest;
use App\Models\Project;
use App\Http\Requests\Projects\StoreProjectRequest;
use App\Http\Requests\Projects\UpdateProjectRequest;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  IndexProjectRequest $request
     * @return \Inertia\Response
     */
    public function index(IndexProjectRequest $request)
    {
        $filters = $request->safe()->filters ?? [];

        return Inertia::render('Projects', [
            'projects'  => Project::query()
                                ->filters($filters)
                                ->withCount(['tasks' => fn($query) => $query->where('status', '!=', TaskStatus::DONE)])
                                ->orderByDesc('created_at')
                                ->paginate()
                                ->withQueryString(),
            'filters'   => $filters
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Projects\StoreProjectRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProjectRequest $request)
    {
        Project::create($request->validated())
            ? session()->flash('success', __('crud.create.success', [ 'item' => 'project' ]))
            : session()->flash('error', __('crud.create.error', [ 'item' => 'project' ]));

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Projects\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated())
            ? session()->flash('success', __('crud.update.success', [ 'item' => 'project' ]))
            : session()->flash('error', __('crud.update.error', [ 'item' => 'project' ]));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        $project->delete()
            ? session()->flash('success', __('crud.delete.success', [ 'item' => 'project' ]))
            : session()->flash('error', __('crud.delete.error', [ 'item' => 'project' ]));

        return redirect()->back();
    }
}
