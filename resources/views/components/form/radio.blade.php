@props([
    'name',
    'options',
    'checked'=> false,
    'label'=>false,
])

@if($label)
    <label for="">{{ $label }}</label>
@endif

@error($name)
<div class="alert alert-danger" role="alert">
    {{$message}}
</div>
@enderror


@foreach($options as $key => $value)

    <div class="form-check">
        <input type="radio" name="{{ $name }}"  value={{ $key }} @checked(old($name,$checked) == $key)
            class="form-check-input @error($name) is-invalid @enderror">

        <label class="form-check-label">
            {{ $value }}
        </label>
    </div>
@endforeach
