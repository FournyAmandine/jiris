<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Models\Contact;
use App\Models\Homework;
use App\Models\Jiri;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class JiriController extends Controller
{

    public function store(Request $request): RedirectResponse
    {
        $validated_data = $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'description' => 'nullable',
            'contacts.*' => 'nullable|array',
            'projects.*' => 'nullable',
        ]);


        $jiri = Jiri::create(array_merge($validated_data, ['user_id'=>Auth::user()->id]));

        if (!empty($validated_data['projects'])) {
            $jiri->projects()->attach($validated_data['projects']);
        }

        if (!empty($validated_data['contacts'])) {
            foreach ($validated_data['contacts'] as $key => $contact) {
                $jiri->contacts()->attach($key, ['role' => $contact['role']]);

                if ($contact['role'] === ContactRoles::Evaluated->value) {
                    $homeworks = Homework::where('jiri_id' , '=', $jiri->id)->pluck('id')->toArray();
                    $correct_contact = Contact::where('contacts.id', '=', $key)->first();

                    $correct_contact->homeworks()->attach($homeworks);
                }
            }
        }



        return redirect(route('jiris.index'));
    }

    public function index()
    {
        $jiris = Auth::user()->jiris;

        return view('jiris.index', compact('jiris'));
    }

    public function show(Jiri $jiri)
    {
        $contacts = Contact::all();
        $projects = Project::all();
        return view('jiris.show', compact('jiri', 'contacts', 'projects'));
    }

    public function create()
    {
        return view('jiris.create');
    }

    public function edit(Jiri $jiri)
    {
        $contacts = Contact::all();
        $projects = Project::all();
        return view('jiris.edit', compact('jiri', 'contacts', 'projects'));
    }
}
