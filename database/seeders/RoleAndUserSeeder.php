<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            "Super Admin", "Clinic Admin", "Doctor",
            "Lab Technician", "X-Ray Technician", "Manpower Agency", "Patient",
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(["name" => $roleName]);

            $email = strtolower(str_replace(" ", "", $roleName)) . "@fememis.test";

            User::firstOrCreate(
                ["email" => $email],
                [
                    "name" => $roleName . " Demo",
                    "password" => Hash::make("password"),
                    "role_id" => $role->id,
                ]
            );
        }
    }
}
