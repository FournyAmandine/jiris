<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function store()
    {
        $validated = request()->validate([
            'name' => 'required',
        ]);
        Project::create(request()->all());

        return redirect(route('projects.index'));
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
}
