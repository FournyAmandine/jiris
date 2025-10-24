<x-head>
    <x-slot:title>
        {!! $jiri->name !!} - Jiri
    </x-slot:title>
</x-head>
<body class="w-1/2 m-auto">
<header class="mt-20 mb-20">
    <div class="flex items-center justify-center mb-10 mt-10">
        @include('svg.student_cap')
        <h1 class="text-4xl ml-5 font-bold">Récapitulatif du jiri : {{$jiri->name}}</h1>
    </div>
</header>
<main>
    <section class="">
        <div class="flex p-5 gap-10 flex-wrap bg-gray-100 shadow-2xl rounded-2xl">
            <x-show.div>
                <x-slot:title>
                    Nom
                </x-slot:title>
                <x-slot:text>
                    {{ $jiri->name}}
                </x-slot:text>
            </x-show.div>
            <x-show.div>
                <x-slot:title>
                    Date
                </x-slot:title>
                <x-slot:text>
                    {{ \Carbon\Carbon::parse($jiri->date)->translatedFormat('d/m/Y') }}
                </x-slot:text>
            </x-show.div>
            <x-show.div>
                <x-slot:title>
                    Description
                </x-slot:title>
                <x-slot:text>
                    {{ $jiri->description}}
                </x-slot:text>
            </x-show.div>
            <x-show.div>
                <x-slot:title>
                    Evalués
                </x-slot:title>
                <x-slot:text>
                    {{ $jiri->evaluated->count()}}
                </x-slot:text>
            </x-show.div>
            <x-show.div>
                <x-slot:title>
                    Evaluateurs
                </x-slot:title>
                <x-slot:text>
                    {{ $jiri->evaluators->count()}}
                </x-slot:text>
            </x-show.div>
            <x-show.div>
                <x-slot:title>
                    Projets
                </x-slot:title>
                <x-slot:text>
                    {{ $jiri->homeworks->count()}}
                </x-slot:text>
            </x-show.div>
        </div>
    </section>
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
            {!! route('jiris.edit', $jiri->id) !!}
        </x-slot:href>
    </x-link>
    </section>
</main>

</body>
<x-footer></x-footer>
