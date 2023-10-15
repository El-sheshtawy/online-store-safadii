<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Locales;

class ProfileController extends Controller
{
    public function edit()
    {
        // countries and locales using Symfony Package The Intl Component
        return view('dashboard.profile.edit',[
            'admin' => Auth::guard('admin')->user(),
            'countries' => Countries::getNames(),
            'locales' => Locales::getNames(),
        ]);
    }


    public function update(UpdateProfileRequest $request)
    {
        $admin = Auth::guard('admin')->user();
        $admin->profile()->updateOrCreate(
            [
                 'admin_id'=>$admin->id,
            ],
            [
                 'first_name'=>$request->first_name,
                 'last_name'=>$request->last_name,
                 'birthday'=>$request->birthday,
                 'gender'=>$request->gender,
                 'street_address'=>$request->street_address,
                 'city'=>$request->city,
                 'state'=>$request->state,
                 'country'=> $request->country,
                 'locale'=>$request->_locale,
        ]);

       return redirect()->route('admin.profile.edit')->with('success','Profile Updated');

      //another mehtod for save: $admin->profile->fill($request->all())->save(); but insure that withDefault function in model
    }

}
