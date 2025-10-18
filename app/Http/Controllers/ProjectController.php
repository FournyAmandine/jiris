<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = request()->validate([
            'name' => 'required',
        ]);

        $user = Auth::user();

        $user->projects()->create($validated);

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
