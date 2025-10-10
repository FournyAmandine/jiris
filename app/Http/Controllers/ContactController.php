<?php

namespace App\Http\Controllers;

use App\Models\Contact;

class ContactController extends Controller
{
    public function store()
    {
        Contact::create(request()->all());

        return redirect(route('contacts.index'));
    }

    public function index()
    {
        $validated = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $contacts = Contact::all();

        return view('contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }
}
