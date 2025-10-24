<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Jobs\ProcessUploadedContactAvatar;
use App\Models\Contact;
use App\Models\Jiri;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ContactController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();

        if ($validated['avatar']) {
            $new_original_file_name = uniqid() . '.' . config('contactsavatars.avatar_extension');
            $full_path_to_original = Storage::putFileAs(config('contactsavatars.original_path'),
                $validated['avatar'],
                $new_original_file_name,
            );

            if ($full_path_to_original) {
                $validated['avatar'] = $new_original_file_name;

                ProcessUploadedContactAvatar::dispatch($full_path_to_original, $new_original_file_name);
            } else {
                $validated['avatar'] = '';
            }
        }

        $contact = auth()->user()->contacts()->create($validated);


        return redirect(route('contacts.show', compact('contact')));
    }

    public function index()
    {

        $contacts = Contact::all();

        return view('contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    public function create()
    {
        $projects = Auth::user()->projects;
        $jiris = Auth::user()->jiris;
        return view('contacts.create', compact('jiris', 'projects'));

    }

    public function edit(Contact $contact)
    {
        $jiris = Jiri::all();
        $projects = Project::all();
        return view('contacts.edit', compact('contact', 'projects', 'jiris'));
    }

    public function update(Contact $contact, StoreContactRequest $request)
    {

        $validated = $request->validated();


        $this->authorize('update', $contact);

        $contact->upsert(
            [
                [
                    'id' => $contact->id,
                    'user_id' => \auth()->user()->id,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ],
            ], 'id',
            ['name', 'email']
        );

        return redirect(route('contacts.show', $contact->id));

    }

}
