@extends('dashboard.layouts.master')
@section('content')
    <x-alert/>
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-row">

            <div class="col-md-6">
                <x-form.input name="first_name" type="text" label="First Name"
                              :value="$admin->profile->first_name ?? ''"/>
            </div>

            <div class="col-md-6">
                <x-form.input name="last_name" type="text" label="Last Name" :value="$admin->profile->last_name ?? ''"/>
            </div>

        </div>

        <div class="form-row">
            <div class="col-md-6">
                <x-form.input name="birthday" type="date" label="Birthday" :value="$admin->profile->birthday ?? ''"/>
            </div>

            <div class="col-md-6">
                <x-form.radio
                        label="Gender"
                        name="gender"
                        :options="['male'=> 'Male', 'female'=>'Female', 'other'=>'Other']"
                        :checked="$admin->profile->gender ?? ''"/>
            </div>

            <div class="col-md-6">
                <x-form.input name="street_address" type="text" label="Street Address"
                              :value="$admin->profile->street_address ?? ''"/>
            </div>

            <div class="col-md-6">
                <x-form.input name="city" type="text" label="City" :value="$admin->profile->city ?? ''"/>
            </div>

            <div class="col-md-6">
                <x-form.input name="state" type="text" label="State" :value="$admin->profile->state ?? ''"/>
            </div>


            <div class="col-md-6">
                <x-form.select
                        label="Country"
                        name="country"
                        :options="$countries"
                        :default_id_value="$admin->profile->country ??''"
                        :default_name_value="$admin->profile->country ??'-'"/>
            </div>

            <div class="col-md-6">
                <x-form.select
                        name="_locale"
                        :options="$locales"
                        :default_id_value="$admin->profile->locale ??''"
                        :default_name_value="$admin->profile->locale ??'-'"
                        label="Locale"/>
            </div>
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

@section('page_header')
    Edit Profile
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection


