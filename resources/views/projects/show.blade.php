<x-head>
    <x-slot:title>
        Création d'un projet
    </x-slot:title>
</x-head>
<body>
<x-menu></x-menu>
<div class="flex items-center justify-center mb-10 mt-10">
    @include('svg.files')
    <h1 class="text-4xl ml-5 font-bold">{{$project->name}}</h1>
</div>
<section class="flex justify-center flex-col border mb-20 border-gray-300 rounded-2xl shadow-2xl w-2/5 m-auto">
        <div class="p-10">
            <x-show.div>
                <x-slot:title>
                    Nom
                </x-slot:title>
                <x-slot:text>
                    {{ $project->name}}
                </x-slot:text>
            </x-show.div>
        </div>
    <div class="p-10">
        @foreach($jiris as $jiri)
            <p>{!! $jiri->name !!}</p>
        @endforeach
    </div>
    <x-link>
        Modifier le projet
        <x-slot:class_div>
            w-5/5 flex justify-center m-auto mt-10 border-gray-300 border-t
        </x-slot:class_div>
        <x-slot:class>
            w-4/5 m-auto border-2 block text-center border-amber-900 rounded-lg p-3 my-6 w-1/1 bg-amber-800 text-white
            hover:scale-105
        </x-slot:class>
        <x-slot:href>
            {!! route('projects.edit', $project->id) !!}
        </x-slot:href>
    </x-link>
</section>
</body>
<x-footer>

</x-footer>
