<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    //

    public function users(Request $request){
        $this->authorize('create', User::class);


        $request->validate([
            'excel' => 'required|file|mimes:xls,xlsx',
            'role_id' => 'required|array',
        ]);

        Excel::import(new UsersImport($request->input('role_id')), request()->file('excel'));

        return redirect()->back()->with('success',__('locale.ModelCreated', ['model' => 'Role']));

    }
}
