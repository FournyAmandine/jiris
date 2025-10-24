<?php

namespace App\Http\Controllers;

use App\Enums\ContactRoles;
use App\Events\JiriCreatedEvent;
use App\Http\Requests\StoreJiriRequest;
use App\Mail\JiriCreatedMail;
use App\Models\Contact;
use App\Models\Homework;
use App\Models\Jiri;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class JiriController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreJiriRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $jiri = Auth::user()->jiris()->create($validated);

        if (!empty($validated['projects'])) {
            $jiri->projects()->attach($validated['projects']);
        }

        if (!empty($validated['contacts'])) {
            foreach ($validated['contacts'] as $key => $contact) {
                $jiri->contacts()->attach($key, ['role' => $contact['role']]);

                if ($contact['role'] === ContactRoles::Evaluated->value) {
                    $homeworks = Homework::where('jiri_id' , '=', $jiri->id)->pluck('id')->toArray();
                    $correct_contact = Contact::where('contacts.id', '=', $key)->first();

                    $correct_contact->homeworks()->attach($homeworks);
                }
            }
        }


        event(new JiriCreatedEvent($jiri));

        return redirect(route('jiris.show', $jiri->id));
    }

    public function index()
    {

        $jiris = Jiri::with(['attendances', 'projects'])
            ->where('user_id',  Auth::user()->id)
            ->orderBy('date')
            ->paginate(6);

       foreach ($jiris as $jiri){
           $jiri->name = Str::lower($jiri->name);
       }

        return view('jiris.index', compact('jiris'));
    }

    public function show(Jiri $jiri)
    {
        $jiri->load(['contacts', 'evaluators', 'evaluated', 'projects']);
        return view('jiris.show', compact('jiri'));
    }

    public function create(Jiri $jiri)
    {
        $contacts = Auth::user()->contacts;
        $projects = Auth::user()->projects;
        return view('jiris.create', compact('jiri', 'contacts', 'projects'));
    }

    public function edit(Jiri $jiri)
    {
        $contacts = Contact::all();
        $projects = Project::all();
        return view('jiris.edit', compact('jiri', 'contacts', 'projects'));
    }


    public function update(StoreJiriRequest $request, Jiri $jiri): RedirectResponse
    {
        $this->authorize('update', $jiri);

        /****** Validation des données ******/
        $validated_data = $request->validated();

        /****** Mise à jour des données du Jiri ******/
        $jiri->upsert(
            [
                [
                    'id' => $jiri->id,
                    'user_id' => Auth::user()->id,
                    'name' => $validated_data['name'],
                    'date' => $validated_data['date'],
                    'description' => $validated_data['description'],
                ],
            ],
            'id',
            ['name', 'description', 'date']);

        /****** Récupération des anciens contacts pour mettre à jour les implémentations ******/
        $old_contacts_ids = $jiri->contacts()->pluck('contact_id')->toArray();

        /****** Mise à jour des homeworks ******/
        if (!empty($validated_data['projects'])) {
            $jiri->projects()->sync($validated_data['projects']);
        } else {
            $jiri->projects()->detach();
        }

        /****** Mise à jour des attendances ******/
        if (!empty($validated_data['contacts'])) {
            $jiri->contacts()->sync($validated_data['contacts']);
        } else {
            $jiri->contacts()->detach();
        }

        /****** Implementation : Suppression d'un contact du jiri ******/
        $new_contacts_ids = array_keys($validated_data['contacts'] ?? []);
        $contacts_to_remove = array_diff($old_contacts_ids, $new_contacts_ids);

        if (!empty($contacts_to_remove)) {
            foreach ($contacts_to_remove as $contact_to_remove) {
                if ($contact = Contact::where('id', '=', $contact_to_remove)->first()) {
                    $contact->homeworks()->detach();
                }
            }
        }

        /****** Implementation : Changement de rôle d'un contact ******/
        if (!empty($validated_data['contacts'])) {
            foreach ($validated_data['contacts'] as $id => $contact) {
                $homeworks_id = $jiri->homeworks()->pluck('id');
                $correct_contact = $jiri->contacts->where('id', '=', $id)->first();

                if ($contact['role'] === ContactRoles::Evaluated->value) {
                    $correct_contact->homeworks()->sync($homeworks_id);
                } else {
                    $correct_contact->homeworks()->detach();
                }
            }
        }

        return redirect(route('jiris.show', $jiri->id));
    }
}
