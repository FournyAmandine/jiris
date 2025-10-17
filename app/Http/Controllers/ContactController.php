<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ContactController extends Controller
{
    use AuthorizesRequests;

    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')){
            $image = Image::read($validated['avatar'])
            ->cover(300, 300)
            ->toJpeg(80);
            $file_name = 'contact_'.uniqid().'_300X300.jpg';
            $path = "contacts/$file_name";
            Storage::disk('public')->put($path, $image->toString());
            $validated['avatar'] = $path;
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
        return view('contacts.create');

    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(Contact $contact)
    {
        $this->authorize('update', $contact);

    }
}
