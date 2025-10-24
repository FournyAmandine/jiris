<x-head>
    <x-slot:title>
        {!! $contact->name !!} - Jiri
    </x-slot:title>
</x-head>
<body class="w-1/2 m-auto">
<x-menu></x-menu>
<h1 class="font-bold text-4xl my-15 text-center flex flex-col mx-auto">{{$contact->name}}</h1>

<section class=" border mb-20 border-gray-300 rounded-2xl shadow-2xl">
    <div class="flex p-10 justify-center gap-4 flex-wrap">
        <div>
            @if(isset($contact->avatar))
                <img class="mt-2 max-w-[150px] rounded-xl"
                     src="{!! asset('storage/images/contacts/originals/'.$contact->avatar) !!}"
                     alt="avatar de {{ $contact->name }}">
            @else
                <div class="bg-neutral-100 w-60 h-60 shadow-2xl rounded-2xl flex justify-center items-center p-10">Pas d'avatar pour le moment</div>
            @endif
        </div>
        <div class="p-10">
            <x-show.div>
                <x-slot:title>
                    Nom
                </x-slot:title>
                <x-slot:text>
                    {{ $contact->name}}
                </x-slot:text>
            </x-show.div>
            <x-show.div>
                <x-slot:title>
                    Email
                </x-slot:title>
                <x-slot:text>
                    {{ $contact->email}}
                </x-slot:text>
                <x-slot:class_div>
                    ml-10 mt-10
                </x-slot:class_div>
            </x-show.div>
        </div>
    </div>
    <x-link>
        Modifier le contact
        <x-slot:class_div>
            w-5/5 flex justify-center m-auto mt-10 border-gray-300 border-t
        </x-slot:class_div>
        <x-slot:class>
            w-4/5 m-auto border-2 block text-center border-amber-900 rounded-lg p-3 my-6 w-1/1 bg-amber-800 text-white
            hover:scale-105
        </x-slot:class>
        <x-slot:href>
            {!! route('contacts.edit', $contact->id) !!}
        </x-slot:href>
    </x-link>
</section>
{{--    <x-form.table.table :column_names="['Nom','Adresse email','Avatar']">
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
    </x-form.table.table>--}}


</body>
<x-footer>

</x-footer>
