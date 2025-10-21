<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Contact;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        $project =$user->projects()->create($validated);

        return redirect(route('projects.show', $project->id));
    }

    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function create(Project $project)
    {
        return view('projects.create');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project, StoreProjectRequest $request)
    {

        $validated = $request->validated();


        //$this->authorize('update', $project);

        $project->upsert(
            [
                [
                    'id' => $project->id,
                    'user_id' => \auth()->user()->id,
                    'name' => $validated['name'],
                ],
            ], 'id',
            ['name']
        );

        return redirect(route('projects.show', $project->id));

    }
}
