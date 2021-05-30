<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'order'
    ];

    public function scopeParents(Builder $builder)
    {
        return $builder->whereNull('parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function scopeOrdered(Builder $builder, $direction = 'asc')
    {
        return $builder->orderBy('order', $direction);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
