<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function abilities()
    {
        return $this->hasMany(RoleAbility::class,'role_id');
    }

    public static function createRoleWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->post('name'),
            ]);

            foreach ($request->post('abilities') as $ability_name => $type) {
                RoleAbility::create([
                    'role_id' => $role->id,
                    'ability' => $ability_name,
                    'type' => $type ,
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function updateRoleWithAbilities(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->update([
                'name' => $request->post('name'),
            ]);

            foreach ($request->post('abilities') as $ability_name => $type) {
                RoleAbility::updateOrCreate([
                    'role_id' => $this->id,
                    'ability' => $ability_name,
                ], [
                    'type' => $type,
                ]);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
