<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Add extends Component
{
    public $name;
    public $role = [];
    public $email;
    public function render()
    {
        return view('livewire.user.add');
    }

    public function reset_form(){
        $this->name= "";
        $this->role= "";
        $this->email= "";
    }

    public function store(){
        $validatedData = $this->validate([
            'name' => 'required|string',
            'email' => 'email|required|unique:users',
            'role' => 'required'
        ]);

        $validatedData['password'] = bcrypt(Str::random(8));
        $user = User::create($validatedData);
        $role = Role::find($validatedData['role']);
        $user->assignRole($role);

        $this->reset_form();
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Ο χρήστης ' . $user->name . ' δημιουργήθηκε',
            'icon'=>'success',
        ]);


        $this->emit('user_created', $user->id);

    }
}
