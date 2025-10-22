<?php
/*    dd(auth()->user())
    */?>

<aside class="shadow-2xl fixed top-0 left-0 h-screen bg-gray-100 flex flex-col justify-between">
    <div class="border-b border-amber-500 p-10 text-1xl font-bold">
        <h1 class="text-amber-600">Bonjour, <span class="block text-amber-700 text-2xl">{{auth()->user()->name}}</span> </h1>
    </div>
    <nav class="p-5">
        <ul class="space-y-10 text-xl font-medium flex flex-col pt-5">
            <li><a class="p-5 rounded-2xl hover:bg-amber-200" href="{{route('jiris.index')}}">Mes Jiris</a></li>
            <li><a class="p-5 rounded-2xl hover:bg-amber-200" href="{{route('contacts.index')}}">Mes Contacts</a></li>
            <li><a class="p-5 rounded-2xl w-1/1 hover:bg-amber-200" href="{{route('projects.index')}}">Mes Projets</a></li>
        </ul>
    </nav>
    <div class="border-t border-amber-500">
        <form class="flex items-center" action="{{route('logout')}}" method="post">
            @csrf
            <button type="submit" class="text-amber-700 p-10 text-lg font-medium hover:text-amber-600">Deconnexion</button>
        </form>
    </div>
</aside>
