@props([
    'type' => 'submit',
    'class',
    'button_name'=> false,
])

<button type="{{ $type }}" class="{{ $class }}">{{ $button_name }}</button>



