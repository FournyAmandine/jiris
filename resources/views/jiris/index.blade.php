@component('components.head', ['title' => 'Liste des Jiris'])
@endcomponent
<body class="w-3/5 m-auto">
<div class="flex items-center justify-center my-8">
    @include('svg.student_cap')
    <h1 class="text-4xl ml-5 font-bold">Mes jiris</h1>
</div>

@component('components.menu')
@endcomponent

    <x-table.table :column_names="['Nom','Date','Evalués','Evaluateurs','Projets']">
    @foreach($jiris as $jiri)
        <tr class="hover:bg-gray-50 transition-all duration-200">
            <td class="text-left py-4 px-6 border font-semibold border-gray-200">
                <a href="{{ route('jiris.show', $jiri->id) }}"
                   class="inline-block hover:text-blue-800 hover:underline font-medium transition-colors duration-150 w-1/1"> {{ $jiri->name }}</a>
            </td>
            <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">
                {{ \Carbon\Carbon::parse($jiri->date)->translatedFormat('d/m/Y') }}
            </td>
            <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">{{ $jiri->evaluated->count() }}</td>
            <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">{{ $jiri->evaluators->count() }}</td>
            <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">{{ $jiri->homeworks->count() }}</td>
        </tr>

    @endforeach
    </x-table.table>
</body>

@component('components.footer')
@endcomponent
