<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Spatie\Permission\Models\Role;

class UsersImport implements ToModel,WithHeadingRow,WithUpserts
{
    public function  __construct($role_id)
    {
        $this->role_id = $role_id;
    }

    public function uniqueBy()
    {
        return 'email';
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::create([
            'email' => $row['email'],
            'name' => $row['name'],
            'password' => bcrypt(\Illuminate\Support\Str::random('14'))
        ]);

        foreach ($this->role_id as $role_id){
            $role = Role::find($role_id);
            $user->assignRole($role);
        }

        return $user;
    }
}
