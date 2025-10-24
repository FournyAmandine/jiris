<div  class="flex flex-col flex-1 mb-4">
    <label for="{!! $field_name !!}">{!! $slot !!}</label>
    <input  class="border-2 border-gray-700 rounded-md p-2 mt-1 "
            type="{!! $type ?? 'text' !!}"
    value="{{$value ?? old($field_name)}}"
    name="{!! $field_name !!}"
    id="{!! $field_name !!}"
    placeholder="{!! $placeholder ?? '' !!}"
        {!! $required ?? '' !!}>

    @error($field_name)
    <p class=
           "error text-red-600 text-xs">{{ $message }}</p>
    @enderror
</div>
