<div class="form-group">
    <x-form.input type="text" name="name" :value="$category->name"/>
</div>

<x-form.select
        label="Select Parent Category"
        name="parent_id"
        :options="$parentCategories"
        :default_id_value="$category->mainCategory->id ??''"
        :default_name_value="$category->mainCategory->name ??'-'"
        id_value="id"
        name_value="name"/>

<div class="form-group">
    <x-form.textarea name="description" :value="$category->description" label="Description"/>
</div>

<div class="form-group">
    @if($category->image)
        <x-form.input type="file" name="image" accept="image/*" :value="$category->image" label="Edit Image" />
    @else
        <x-form.input type="file" name="image" accept="image/*" :value="$category->image" label="Add Image" />
    @endif
</div>
    <x-form.radio label="Status:" name="status" :checked="$category->status" :options="['active'=>'Active','archived'=>'Archived']"/>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-info">{{ $button_name }}</button>
</div>
</div>

