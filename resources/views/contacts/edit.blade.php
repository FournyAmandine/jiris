@component('components.head', ['title' => 'Mettre à jour le contact - Jiri'])
@endcomponent
<body>
@component('components.menu')
@endcomponent
<h1 class="font-bold text-4xl my-4 text-center flex flex-col mx-auto">Modifiez votre contact</h1>
<form enctype="multipart/form-data" method="post" action="{{ route('contacts.update', $contact->id) }}"
      class="max-w-1/2 mx-auto my-10 shadow-2xl p-10 rounded-2xl">
    @method('PATCH')
    @csrf
    @component('components.form.fields.input', ['type' => 'text', 'value'=>$contact->name, 'field_name' => 'name', 'placeholder' => 'pedro pascal', 'required' => 'required'])
        Entrez un nom<small class="text-red-600 ml-1">*</small>
    @endcomponent

    @component('components.form.fields.input', ['type' => 'email', 'value'=>$contact->email, 'field_name' => 'email', 'placeholder' => 'pedro.pascal@gmail.com', 'required' => 'required'])
        Entrez votre email<small class="text-red-600 ml-1">*</small>
    @endcomponent

    @component('components.form.fields.input', ['type' => 'file', 'field_name' => 'avatar', 'value'=>asset('storage/'.$contact->avatar)])
        Choisissez votre avatar
    @endcomponent

    @component('components.form.buttons.button', ['text' => 'Modifiez le contact'])
    @endcomponent
</form>
</body>
@component('components.footer')
@endcomponent
