<div class="form-group">
        <x-form.input type="text" name="name" :value="$product->name" label="Product"/>
</div>

<div class="form-group">
    <x-form.select
        name="category_id"
        :options="$parentCategories"
        :default_id_value="$product->category->id ??''"
        :default_name_value="$product->category->name?? ''"
        id_value="id"
        name_value="name"
        label="Select Category"/>
</div>

<div class="form-group">
    <x-form.textarea name="description" :value="$product->description" label="Description"/>
</div>

<div class="form-group">
    <x-form.input name="price" type="number" :value="$product->price" label="Price" />
</div>

<div class="form-group">
    <x-form.input name="compare_price" type="number" :value="$product->compare_price" label="Compare Price" />
</div>

<div class="form-group">
    <x-form.input name="tags" type="text" :value="$tags ?? ''" label="Tags" />
</div>

<div class="form-group">
    @if($product->image)
        <x-form.input label="Edit Image" type="file" name="image" accept="image/*" :value="$product->image" />
    @else
        <x-form.input label="Add Image" type="file" name="image" accept="image/*" :value="$product->image" />
    @endif
</div>
<br>

<div class="form-group">
    <x-form.radio label="Status"
                  name="status"
                  :options="['active'=>'Active','draft'=>'Draft','archived'=>'Archived']"
                  :checked="$product->status" />
</div>
<br>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_name }}</button>
</div>
