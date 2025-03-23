<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;  

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat permissions dengan huruf kecil
        Permission::firstOrCreate(['name' => 'tambah-user']);
        Permission::firstOrCreate(['name' => 'edit-user']);
        Permission::firstOrCreate(['name' => 'hapus-user']);
        Permission::firstOrCreate(['name' => 'lihat-user']);

        // Membuat roles
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'pengaju']);
        Role::firstOrCreate(['name' => 'pr']);

        // Menugaskan permissions kepada role admin
        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('tambah-user');
        $roleAdmin->givePermissionTo('edit-user');
        $roleAdmin->givePermissionTo('hapus-user');
        $roleAdmin->givePermissionTo('lihat-user');
    }
}
