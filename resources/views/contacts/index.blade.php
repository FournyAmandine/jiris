@component('components.head', ['title' => 'Liste des contacts -Jiri'])
@endcomponent
<body class="w-2/5 m-auto">
@component('components.menu')
@endcomponent
<header class="flex items-center justify-center mb-10 mt-10">
    @include('svg.person')
</header>


<x-link>
    Créer un contact
    <x-slot:href>
        {!! route('contacts.create') !!}
    </x-slot:href>
</x-link>

<x-form.table.table :column_names="['Nom','Adresse email','Avatar']">
    {{-- Tu peux aussi mettre les lignes ici --}}
    @foreach($contacts as $contact)
        <tr class="hover:bg-indigo-50 transition-all duration-200 border-b border-gray-100">
            <td class="px-6 py-4 border-b border-gray-200">
                <a class="text-indigo-600 hover:text-indigo-800 font-medium underline-offset-2 hover:underline"
                   href="{{ route('contacts.show', $contact->id) }}">{{ $contact->name}}</a></td>
            <td class="px-6 py-4 border-l border-b border-gray-200">
                {{ $contact->email }}
            </td>

        @if(isset($contact->avatar))
                <td class="px-6 py-4 border-l border-b border-gray-200">
                    <img class="mt-2 max-w-[150px] rounded-xl text-indigo-600 hover:underline"
                         src="{!! asset('storage/images/contacts/originals/'.$contact->avatar) !!}"
                         alt="avatar de {{ $contact->name }}">
                </td>
            @else
            <td class="px-6 py-4 border-l border-b border-gray-200">
                <p>Pas d'avatar pour le moment</p>
            </td>
         @endif
        </tr>
    @endforeach
</x-form.table.table>
</body>
@component('components.footer')
@endcomponent
