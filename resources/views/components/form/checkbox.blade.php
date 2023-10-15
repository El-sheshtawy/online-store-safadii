@props([
    'label_name' => false,
    'name',
    'options',
    'id' => false,
    'id_value' => false,
    'name_value' => false,
])

<label>{{$label_name}}</label>

@foreach($options as $option)
    <div class="form-check">
    <x-form.input type="checkbox" name="{{ $name }}" value="{{ $option-> $id_value }}" class="form-check-input" />
    <x-form.label for="{{ $id }}" class="form-check-label">{{ $option->$name_value }}</x-form.label>
    </div>
@endforeach


