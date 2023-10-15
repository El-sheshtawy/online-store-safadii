<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

// This scope will apply to Product Model
class StoreScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $admin = Auth::guard('admin')->user();
        if ($admin && $admin->store_id){
            $builder->where('store_id','=', $admin->store_id);
        }
    }
}
