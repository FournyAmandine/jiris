<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'avatar'=> 'nullable|image',
        ]);

        if ($request->hasFile('avatar')){
            $path = Storage::disk('public')->putFile('contacts', $request->file('avatar'));
            //$file_name = uniqid('contact_').'.jpg';
            //$path = "contact/$file_name";
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
}
