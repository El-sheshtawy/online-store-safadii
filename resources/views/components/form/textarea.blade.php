@props([
    'name',
    'value',
    'label'=>false
])

@if($label)
    <label for="">{{ $label }}</label>
@endif

@error($name)
<div class="alert alert-danger" role="alert">
    {{$message}}
</div>
@enderror

<textarea  name="{{ $name }}" class="form-control @error($name) is-invalid @enderror">
    {{ old($name, $value) }}
</textarea>

