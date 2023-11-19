<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(){
        $breadcrumbs = [
            ['link' => "/", 'name' => __('Home')], ['name' => __('Permissions by Roles')]
        ];
        return view('content.permissions.byrole',compact('breadcrumbs'));
    }

    public function by_user(){
        $breadcrumbs = [
            ['link' => "/", 'name' => __('Home')], ['name' => __('Permissions by Users')]
        ];

        $users = User::whereHas('roles',function ($q){ $q->where('name' ,'!=', 'super-admin'); })->get();
        return view('content.permissions.byuser',compact('users','breadcrumbs'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'permissions.*' => 'required|array',
        ]);

        DB::table('role_has_permissions')->truncate();

        foreach ($validated['permissions'] as $role => $permissionIds) {
            $insert = collect($permissionIds)->map(fn ($id) => [
                'role_id' => $role,
                'permission_id' => $id
            ])->toArray();
            //dd($insert);

            DB::table('role_has_permissions')->insert($insert);
        }

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->back()->with('success',__('Created', ['model' => __('Permission')]));

    }

    public function store_by_user(Request $request){
        $validated = $request->validate([
            'permissions.*' => 'required|array',
        ]);

        foreach ($validated['permissions'] as $user_id => $permissionIds) {
            $user = User::find($user_id);
            $user->syncPermissions();
            foreach($permissionIds as $permissionId){
                $permission = Permission::find($permissionId);
                if(!$user->hasPermissionTo($permission->name)) {
                    $user->givePermissionTo($permission->name);
                }
            }
        }

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->back()->with('success',__('Updated', ['model' => __('Permission')]));

    }
}
