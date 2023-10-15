<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'status',
        'slug',
        'image',
    ];

    public function mainCategory()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status','=','active');
    }
    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }
    public function childCategories()
    {
        return $this->hasMany(Category::class,'parent_id');
    }
}
