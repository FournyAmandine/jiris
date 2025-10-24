@props(['column_names' => []])

<table class="min-w-full border mb-20 border-gray-300 border-separate border-spacing-0 rounded-2xl shadow-2xl overflow-hidden">
    <thead>
    <tr>
        @foreach($column_names as $column_name)
            <th scope="col"
                class="py-4 px-6 text-center font-semibold border-r-2 border-b-2 border-gray-300">
                {{ $column_name }}
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    {{ $slot }}
    </tbody>
</table>
