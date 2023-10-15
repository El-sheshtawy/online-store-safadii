@props([
    'label'=>false,
    'name',
    'options',
     'default_id_value'=>false,
    'default_name_value'=>false,
    'id_value'=>false,
    'name_value'=>false,
])
@if($label)
    <label for="">{{ $label }}</label>
@endif

@error($name)
<div class="alert alert-danger" role="alert">
    {{$message}}
</div>
@enderror

<select name="{{ $name }}" class="form-control @error($name) is-invalid @enderror form-select">
    <option value="{{ $default_id_value  ?? '' }}" style="font-weight: bold;color: black">
        {{ $default_name_value ?? '-' }}
    </option>
    @foreach($options as $option)
        <option value="{{ $option->$id_value ?? $option }}" @selected(old($name) == $option)>
            {{ $option->$name_value ?? $option }}
        </option>
    @endforeach
</select>



