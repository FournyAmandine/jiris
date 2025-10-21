<!doctype html>
<html lang="{!! App::getLocale(); !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('page-title.list')}} - Jiri </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-3/5 m-auto">
<div class="flex items-center justify-center my-8">
    <svg class="" height="80px" width="80px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
         xmlns:xlink="http://www.w3.org/1999/xlink"
         viewBox="0 0 512 512" xml:space="preserve">
        <g>
            <path class="st0" d="M505.837,180.418L279.265,76.124c-7.349-3.385-15.177-5.093-23.265-5.093c-8.088,0-15.914,1.708-23.265,5.093
		L6.163,180.418C2.418,182.149,0,185.922,0,190.045s2.418,7.896,6.163,9.627l226.572,104.294c7.349,3.385,15.177,5.101,23.265,5.101
		c8.088,0,15.916-1.716,23.267-5.101l178.812-82.306v82.881c-7.096,0.8-12.63,6.84-12.63,14.138c0,6.359,4.208,11.864,10.206,13.618
		l-12.092,79.791h55.676l-12.09-79.791c5.996-1.754,10.204-7.259,10.204-13.618c0-7.298-5.534-13.338-12.63-14.138v-95.148
		l21.116-9.721c3.744-1.731,6.163-5.504,6.163-9.627S509.582,182.149,505.837,180.418z"/>
            <path class="st0" d="M256,346.831c-11.246,0-22.143-2.391-32.386-7.104L112.793,288.71v101.638
		c0,22.314,67.426,50.621,143.207,50.621c75.782,0,143.209-28.308,143.209-50.621V288.71l-110.827,51.017
		C278.145,344.44,267.25,346.831,256,346.831z"/>
        </g>
</svg>
    <h1 class="text-4xl ml-5 font-bold">Mes jiris</h1>
</div>

<table class="min-w-full border border-gray-300 border-separate border-spacing-0 rounded-2xl shadow-2xl overflow-hidden">

    <thead class="bg-gray-200 text-lg">
    <tr>
        <th scope="col" class="py-4 px-6 text-center font-semibold border-r-2 border-b-2 border-gray-300">Nom</th>
        <th scope="col" class="py-4 px-6 text-center font-semibold border-r-2 border-b-2 border-gray-300">Date</th>
        <th scope="col" class="py-4 px-6 text-center font-semibold border-r-2 border-b-2 border-gray-300">Évalués</th>
        <th scope="col" class="py-4 px-6 text-center font-semibold border-r-2 border-b-2 border-gray-300">Évaluateurs</th>
        <th scope="col" class="py-4 px-6 text-center font-semibold border-b-2 border-gray-300">Projets</th>
    </tr>
    </thead>

    <tbody>
    @foreach($jiris as $jiri)
        <tr class="hover:bg-gray-50 transition-all duration-200">
            <td class="text-left py-4 px-6 border font-semibold border-gray-200">
                <a href="{{ route('jiris.show', $jiri->id) }}"
                   class="inline-block hover:text-blue-800 hover:underline font-medium transition-colors duration-150 w-1/1"> {{ $jiri->name }}</a>
            </td>
            <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">
                {{ \Carbon\Carbon::parse($jiri->date)->translatedFormat('d/m/Y') }}
            </td>
            <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">{{ $jiri->evaluated_count }}</td>
            <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">{{ $jiri->evaluators_count }}</td>
            <td class="text-center py-4 px-6 border border-gray-200 text-gray-700">{{ $jiri->projects_count }}</td>
        </tr>

    @endforeach
    </tbody>
</table>


</body>
</html>
