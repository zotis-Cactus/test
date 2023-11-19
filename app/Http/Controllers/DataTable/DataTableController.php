<?php

namespace App\Http\Controllers\DataTable;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class DataTableController extends Controller
{

    public function users(){
        //$users = User::with('roles')->get();
        $users = User::whereHas('roles',function ($q){ $q->where('name' ,'!=', 'super-admin'); })->get();
        return datatables()->of($users)
            ->editColumn('roles', function(User $user) {
                $html="";
                foreach($user->roles as $role){
                    $html .= '<span class="badge rounded-pill badge-light-primary">';
                    $html .= $role->name;
                    $html .= '</span>';
                }
                return $html;
            })
            ->addColumn('edit', function (User $user){
                return '<a href="javascript:;" data-id="'.$user->id. '" class="item-edit">'
                    .'<i class="fas fa-pen">'.
                    '</a>';
            })
            ->addColumn('delete', function (User $user){
                return '<form class="delete-form" method="POST" action="'.route('users.delete',$user->id).'">
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="'. csrf_token() .'" />
                        <button type="submit" class="delete delete-button btn btn-group-sm">
                          <i class="fas fa-times"></i>
                        </button>
                        </form>';
            })
            ->rawColumns(['roles','edit','delete'])
            ->make(true);

    }

    public function logs(){
        $logs = Activity::query();
        return datatables()->of($logs)
            ->make(true);
    }
    public function roles(){
        $roles = Role::where('name' ,'!=', 'super-admin');
        return datatables()->of($roles)
            ->addColumn('actions', function (Role $role){
                return '
                <div class="d-flex align-items-center">
                <a href="javascript:;" data-type="edit" data-bs-toggle="modal" data-model-name="role" data-bs-target="#modal-form" data-bs-id="'.$role->id. '" class="btn-sm btn item-edit">'
                    .'<i class="fas fa-pen"></i>'.
                    '</a>
                        <form class="delete-form" method="POST" action="'.route('roles.delete',$role->id).'">
                            <input type="hidden" name="_method" value="delete" />
                            <input type="hidden" name="_token" value="'. csrf_token() .'" />
                            <button type="submit" class="delete delete-button btn btn-sm btn-flat-danger">
                              <i class="fas fa-times"></i>
                            </button>
                            </form>
                        </div>';
            })
            ->blacklist(['actions'])
            ->rawColumns(['actions'])
            ->make(true);
    }
}
