<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ModelPolicy
{

    public function __construct()
    {
        //
    }

//    public function before($user, $ability)
//    {
//        $user = Auth::guard('admin')->user();
//        if ($user->super_admin) {
//            return true;
//        }
//    }


    public function __call($name, $arguments)
    {
        $modelName =Str::plural(Str::lower(str_replace('Policy', '',class_basename($this))));
        if ($name == 'viewAny') {
            $name = 'view';
        }
        $ability = $modelName.'.'.Str::kebab($name);
        $user = $arguments[0];

        if (isset($arguments[1])) {
            $model = $arguments[1];
            if ($model->store_id !== $user->store_id) {
                return false;
            }
        }
        return $user->hasAbility($ability);
    }
}
