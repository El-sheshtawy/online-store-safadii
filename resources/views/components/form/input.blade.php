@props([
    'type'=>false,
    'name',
    'value'=>false,
    'label'=>false,
    'id' => false,
    'class' => "form-control @error($name) is-invalid @enderror",
])

@error($name)
<div class="alert alert-danger" role="alert">
    {{$message}}
</div>
@enderror

@if($label)
    <label for="">{{ $label }}</label>
@endif

<input type="{{ $type }}" name="{{ $name }}"
       value="{{ old($name, $value) }}" class={{ $class }}>

