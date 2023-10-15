<div class="form-group">
    <x-form.input  name="name" type="text" :value="$role->name"/>
</div>

<fieldset>

    <legend style="color: sandybrown; text-align: center">{{__('Abilities')}}</legend>
    <br>
    @foreach(app('abilities') as $ability_key => $ability_name)
        <div class="row mb-2">

            <div class="col-md-6">
                {{ is_callable($ability_name) ? $ability_name() : $ability_name }}
            </div>

            <div class="col-md-2">
                <input type="radio" name="abilities[{{ $ability_key }}]" value="allow"
                    @checked(($role_abilities[$ability_key] ??'') == 'allow')>
                <span>Allow</span>
            </div>

            <div class="col-md-2">
                <input type="radio" name="abilities[{{ $ability_key }}]" value="deny"
                    @checked(($role_abilities[$ability_key] ??'') == 'deny')/>
                <span>Deny</span>
            </div>

            <div class="col-md-2">
                <input type="radio" name="abilities[{{ $ability_key }}]" value="inherit"
                    @checked(($role_abilities[$ability_key] ?? '') == 'inherit') />
                <span>Inherit</span>
            </div>
        </div>
    @endforeach
</fieldset>

<br>
<div class="form-group">
<button type="submit" class="btn btn-danger">{{ $button_name }}</button>
</div>

