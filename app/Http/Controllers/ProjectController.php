<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;
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

    public function show(StoreProjectRequest $project)
    {
        $contacts = Auth::user()->contacts;
        $jiris = $project->jiris()->attach($project['jiris']);
        return view('projects.show', compact('project', 'jiris', 'contacts'));
    }

    public function create()
    {
        $contacts = Auth::user()->contacts;
        $jiris = Auth::user()->jiris;
        return view('projects.create', compact('jiris', 'contacts'));
    }

    public function edit(Project $project)
    {
        $contacts = Contact::all();
        $jiris = Jiri::all();
        return view('projects.edit', compact('project', 'jiris', 'contacts'));
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
