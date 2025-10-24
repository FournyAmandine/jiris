<x-head>
    <x-slot:title>
        Liste des projets
    </x-slot:title>
</x-head>
<body class="w-2/5 m-auto">

<x-menu></x-menu>

<header>
    <div class="flex items-center justify-center mb-10 mt-10">
        @include('svg.files')
        <h1 class="text-4xl ml-5 font-bold">Mes projets</h1>
    </div>
</header>

<x-link>
    Créer un projet
    <x-slot:href>
        {!! route('projects.create') !!}
    </x-slot:href>
</x-link>

<main class="w-4/5 m-auto">
    <x-form.table.table :column_names="['Nom']">
        @foreach($projects as $project)
            <tr class="hover:bg-gray-50 transition-all duration-200">
                <td class="text-left py-4 px-6 border font-semibold border-gray-200">
                    <a href="{{ route('projects.show', $project->id) }}"
                       class="inline-block  text-center hover:text-blue-800 hover:underline font-medium transition-colors duration-150 w-1/1"> {{ $project->name }}</a>
                </td>
            </tr>

        @endforeach
    </x-form.table.table>
</main>

</body>

<x-footer>

</x-footer>
