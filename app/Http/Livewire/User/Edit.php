<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    public $name;
    public $role=[];
    public $email;
    public User $user;

    use AuthorizesRequests;
    protected $listeners = ['editUser'];


    public function render()
    {
        return view('livewire.user.edit');
    }

    public function editUser(User $user){
        $this->user = $user;
        $this->authorize('view', $this->user);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles()->pluck('id');

        $this->emit('UserRole', $this->role);
    }

    public function updateUser(){
        $this->authorize('update', $this->user);

        $validatedData = $this->validate([
            'name' => 'required|string',
            'email' => 'email|required|unique:users,email,'.$this->user->id,
            'role' => 'required'
        ]);
        $this->user->update($validatedData);
        DB::table('model_has_roles')->where('model_id',$this->user->id)->delete();
        $this->user->assignRole($this->role);

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Ο χρήστης ' . $this->user->name . ' ανανεώθηκε',
            'icon'=>'success',
        ]);


        $this->emit('user_updated', $this->user->id);
    }
}
