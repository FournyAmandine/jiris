<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes projets - Jiri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-2/5 m-auto">
<header>
    <div class="flex items-center justify-center mb-10 mt-10">
        <svg fill="#000000" width="80px" height="80px" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
            <path d="M213.65723,66.34326l-40-40A8.00076,8.00076,0,0,0,168,24H88A16.01833,16.01833,0,0,0,72,40V56H56A16.01833,16.01833,0,0,0,40,72V216a16.01833,16.01833,0,0,0,16,16H168a16.01833,16.01833,0,0,0,16-16V200h16a16.01833,16.01833,0,0,0,16-16V72A8.00035,8.00035,0,0,0,213.65723,66.34326ZM136,192H88a8,8,0,0,1,0-16h48a8,8,0,0,1,0,16Zm0-32H88a8,8,0,0,1,0-16h48a8,8,0,0,1,0,16Zm64,24H184V104a8.00035,8.00035,0,0,0-2.34277-5.65674l-40-40A8.00076,8.00076,0,0,0,136,56H88V40h76.68652L200,75.314Z"/>
        </svg>
        <h1 class="text-4xl ml-5 font-bold">Mes projets</h1>
    </div>
</header>

<main>
    <table class="min-w-full border border-gray-300 border-separate border-spacing-0 rounded-2xl shadow-2xl overflow-hidden">

        <thead class="bg-gray-200 text-lg">
        <tr>
            <th scope="col" class="py-4 px-6 text-center font-semibold border-r-2 border-b-2 border-gray-300">Nom</th>
            <th scope="col" class="py-4 px-6 text-center font-semibold border-r-2 border-b-2 border-gray-300">Date</th>
        </tr>
        </thead>

        <tbody>
        @foreach($projects as $project)
            <tr class="hover:bg-gray-50 transition-all duration-200">
                <td class="text-left py-4 px-6 border font-semibold border-gray-200">
                    <a href="{{ route('jiris.show', $project->id) }}"
                       class="inline-block hover:text-blue-800 hover:underline font-medium transition-colors duration-150 w-1/1"> {{ $project->name }}</a>
                </td>
                <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">
                    {{ \Carbon\Carbon::parse($project->date)->translatedFormat('d/m/Y') }}
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</main>

</body>
</html>
