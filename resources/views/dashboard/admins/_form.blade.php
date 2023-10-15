<div class="form-group">
    <x-form.input label="Name"  name="name" type="text" :value="$admin->name" />
</div>
<div class="form-group">
    <x-form.input label="Email" type="email" name="email" :value="$admin->email"/>
</div>

<fieldset>
    <legend>{{ __('Roles') }}</legend>
@foreach ($roles as $role)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                @isset($adminRoles)
                    @checked(in_array($role->id, old('roles', $adminRoles)))
                @endisset>
        <label class="form-check-label">{{ $role->name }}</label>
    </div>
@endforeach
</fieldset><br>

<div class="form-group">
<button type="submit" class="btn btn-primary">{{ $button_name }}</button>
</div>

