@props([
    'id'=>'',
    'class' => false,
])

<label for="{{ $id }}" class="{{ $class }}">{{ $slot }}</label>


