<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'patient.view',
            'patient.edit',
            'appointment.manage',
            'medical.enter',
            'medical.review',
            'certificate.generate',
            'certificate.view',
            'clinic.approve',
            'clinic.manage',
            'report.export',
            'audit.view',
            'user.manage',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        $map = [
            'Super Admin' => $permissions, // everything

            'Clinic Admin' => [
                'patient.view',
                'patient.edit',
                'appointment.manage',
                'user.manage',
            ],

            'Doctor' => [
                'patient.view',
                'medical.review',
                'certificate.generate',
                'certificate.view',
            ],

            'Lab Technician' => [
                'patient.view',
                'medical.enter',
            ],

            'X-Ray Technician' => [
                'patient.view',
                'medical.enter',
            ],

            'Manpower Agency' => [
                'certificate.view',
            ],

            'Patient' => [
                'certificate.view',
            ],
        ];

        foreach ($map as $roleName => $permNames) {
            $role = Role::where('name', $roleName)->first();

            if (!$role) {
                continue;
            }

            $ids = Permission::whereIn('name', $permNames)->pluck('id');
            $role->permissions()->sync($ids);
        }
    }
}
