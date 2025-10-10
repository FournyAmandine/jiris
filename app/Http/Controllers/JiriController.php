<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Homework;
use App\Models\Jiri;

class JiriController extends Controller
{
    public function store()
    {
                $validated = request()->validate([
                    'name' => 'required',
                    'date' => 'required|date',
                    'description' => 'nullable',
                    'projects.*' => 'nullable|integer',
                    'contacts.*' => 'nullable|integer',
                    'roles.*' => 'nullable'
                ]);

                $jiri = Jiri::create($validated);
                $jiri->projects()->attach($validated['projects']);
                $roles = [];
                foreach ($validated['contacts'] as $contact){
                    $role = $validated['roles'][$contact]??'none';
                    $roles[$contact] = ['role'=>$role];
                }
                $jiri->contacts()->attach($roles);

                return redirect(route('jiris.index'));

    }

    public function index()
    {
        $jiris = Jiri::all();

        return view('jiris.index', compact('jiris'));
    }

    public function show(Jiri $jiri)
    {
        return view('jiris.show', compact('jiri'));
    }

    public function create()
    {
        return view('jiris.create');
    }
}
