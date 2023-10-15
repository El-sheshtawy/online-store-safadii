<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'slug', 'description', 'image', 'category_id', 'store_id', 'price', 'compare_price','status'];

    protected $hidden = ['image', 'created_at', 'updated_at', 'deleted_at', 'quantity'];

    protected $appends = ['image_url'];

    protected static function booted()
    {
       static::addGlobalScope(new StoreScope());
       static::creating(function (Product $product)
       {
           $product->slug = Str::slug($product->name);
       });
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag', 'product_id', 'tag_id',
            'id',
            'id',
        );
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status','=','active');
    }

    // Accessor
    public function getImageUrlAttribute()
    {
        $image = $this->image;
        if (! $image) {
            return 'https://app.advaiet.com/item_dfile/default_product.png';
        }
        if (Str::startsWith($image, ['http://', 'https://'])) {
            return $image;
        }
        return asset("images/products/{$image}");
    }


    // Accessor
    public function getSalePercentAttribute()
    {
        if (is_null($this->compare_price))
        {
            return 0;
        }
        return round(( $this->compare_price / $this->price) * 100,1);
    }

    public function scopeFilter(Builder $builder, $filter)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ],$filter);

        $builder->when($options['status'], function ($query, $status){
            return $query->where('status', $status);
        });

        $builder->when($options['store_id'], function ($builder, $value){
            $builder->where('store_id', $value);
        });

        $builder->when($options['category_id'], function ($builder, $value){
            $builder->where('category_id', $value);
        });

        $builder->when($options['tag_id'], function ($builder, $value){

            $builder->whereExists(function ($query) use ($value) {
                $query->select(1)
                    ->from('product_id')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });

//            $builder->whereHas('tags', function ($builder) use ($value){
//                $builder->whereE('id',$value);
//            });
//          $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)',[$value]);
        });

    }

    public function escapedName(): Attribute
    {
        return Attribute::get(fn() => new HtmlString(nl2br(e($this->name))) );
    }

    public function escapedDescription(): Attribute
    {
        return Attribute::get(
            fn () => Str::of($this->description)->markdown([
                'html_input' => 'escape',
                'allow_unsafe_links' => false,
                'max_nesting_level' => 5,
            ])->toHtmlString()
        );
    }
}
