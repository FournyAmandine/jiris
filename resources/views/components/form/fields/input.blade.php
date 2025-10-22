<div  class="flex flex-col flex-1 mb-4">
    <label for="{!! $field_name !!}">{!! $slot !!}</label>
    <input  class="border-1 border-gray-300 rounded-md p-1 mt-1"
            type="{!! $type ?? 'text' !!}"
    value="{{old($field_name)}}"
    name="{!! $field_name !!}"
    id="{!! $field_name !!}"
    placeholder="{!! $placeholder ?? '' !!}"
        {!! $required ?? '' !!}>

    @error($field_name)
    <p class=
           "error text-red-600 text-xs">{{ $message }}</p>
    @enderror
</div>
