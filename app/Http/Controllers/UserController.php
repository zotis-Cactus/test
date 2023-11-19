<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct(User $user){
        $this->user = $user;
        $this->authorizeResource(User::class,'user');
    }
    public function index(){
        $breadcrumbs = [
            ['link' => "home", 'name' => __('locale.Home')], ['name' => __('locale.Users')]
        ];
        return view('content.users.index', ['breadcrumbs' => $breadcrumbs]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
        ]);


        //dd($validated);

        $user = new User();
        $user->name= $validated['name'];
        $user->email= $validated['email'];
        $user->password = bcrypt(Str::random(8));
        $user->save();

        return redirect()->back()->with('success',__('locale.ModelCreated', ['model' => __('locale.User')]));
    }

    public function delete(Request $request, User $user){
        $user->delete();

        return redirect()->back()->with('success',__('Deleted', ['model' => __('locale.User')]));
    }

    public function viewUserSettings(){
        return view('content.users.settings');
    }
}
