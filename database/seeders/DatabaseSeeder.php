<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create initial admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'phone' => '1234567890',
                'address' => 'Admin Address',
                'status' => 'approved',
                'profile_photo' => null,
                'id_front' => null,
                'id_back' => null,
                'role' => 'admin',
                'password' => Hash::make('password'), // Change after first login
            ]
        );
        $admin->assignRole($adminRole);

        // Seed multiple pending users for admin dashboard testing
        $users = \App\Models\User::factory()->count(12)->create([
            'status' => 'pending',
            'role' => 'user',
        ]);

        // Add sample audit logs for the first 3 users
        $sampleActions = [
            ['action' => 'rejected', 'reason' => 'Incomplete documents'],
            ['action' => 'approved', 'reason' => null],
            ['action' => 'rejected', 'reason' => 'Invalid ID provided'],
        ];
        foreach ($users->take(3) as $i => $user) {
            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'admin_id' => $admin->id,
                'action' => $sampleActions[$i]['action'],
                'reason' => $sampleActions[$i]['reason'],
                'created_at' => now()->subDays(3 - $i),
            ]);
        }
    }
}
