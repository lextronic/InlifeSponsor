<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'address' => 'Admin Address',
            'role' => 'admin',  // Role admin
            'level' => null,
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');
    
        // PR User
        $pr = User::create([
            'name' => 'PR User',
            'email' => 'pr@gmail.com',
            'address' => 'PR Address',
            'role' => 'pr',
            'level' => null,
            'password' => bcrypt('password123'),
        ]);
        $pr->assignRole('pr');
    
        // Pengaju User - Student role
        $pengajuStudent = User::create([
            'name' => 'Pengaju',
            'email' => 'pengaju_student@gmail.com',
            'address' => 'Pengaju Student Address',
            'role' => 'pengaju',  // Role pengaju
            'level' => 'student',  // Level student
            'password' => bcrypt('password123'),
        ]);
        $pengajuStudent->assignRole('pengaju'); // Assign role 'pengaju'
    
        // Pengaju User - Event Organizer role
        $pengajuEventOrganizer = User::create([
            'name' => 'Pengaju',
            'email' => 'pengaju_event_organizer@gmail.com',
            'address' => 'Pengaju Event Organizer Address',
            'role' => 'pengaju',  // Role pengaju
            'level' => 'event_organizer',  // Level event_organizer
            'password' => bcrypt('password123'),
        ]);
        $pengajuEventOrganizer->assignRole('pengaju'); // Assign role 'pengaju'
    }
    
}
