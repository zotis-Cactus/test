<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public function index(){
        $breadcrumbs = [
            ['link' => "home", 'name' => __('locale.Home')], ['name' => __('Roles')]
        ];
        return view('content.roles.index',compact('breadcrumbs'));
    }

    public function show(Request $request, Role $role){
        if($request->ajax()){
            return $role->toJson();
        }
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        Role::create(['guard_name' => 'web','name' => $validated['name']]);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->back()->with('success',__('Created', ['model' => __('Role')]));
    }

    public function update(Request $request, Role $role){
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);
        $role->update($validated);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->back()->with('success',__('Updated', ['model' => __('Role')]));
    }

    public function delete(Request $request, Role $role){
        $role->delete();

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->back()->with('success',__('Deleted', ['model' => __('Role')]));
    }



}
