<x-head>
    <x-slot:title>
        Liste des projets
    </x-slot:title>
</x-head>
<body class="w-2/5 m-auto">
<header>
    <div class="flex items-center justify-center mb-10 mt-10">
        <svg fill="#000000" width="80px" height="80px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
            <path d="M213.65723,66.34326l-40-40A8.00076,8.00076,0,0,0,168,24H88A16.01833,16.01833,0,0,0,72,40V56H56A16.01833,16.01833,0,0,0,40,72V216a16.01833,16.01833,0,0,0,16,16H168a16.01833,16.01833,0,0,0,16-16V200h16a16.01833,16.01833,0,0,0,16-16V72A8.00035,8.00035,0,0,0,213.65723,66.34326ZM136,192H88a8,8,0,0,1,0-16h48a8,8,0,0,1,0,16Zm0-32H88a8,8,0,0,1,0-16h48a8,8,0,0,1,0,16Zm64,24H184V104a8.00035,8.00035,0,0,0-2.34277-5.65674l-40-40A8.00076,8.00076,0,0,0,136,56H88V40h76.68652L200,75.314Z"/>
        </svg>
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
