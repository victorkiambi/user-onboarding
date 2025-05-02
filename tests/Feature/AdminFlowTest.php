<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_access_dashboard()
    {
        $this->seed();
        $admin = User::factory()->create([
            'email' => 'adminlogin@example.com',
            'password' => bcrypt('password'),
            'status' => 'approved',
        ]);
        $admin->assignRole('admin');
        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($admin);
        $dashboard = $this->actingAs($admin)->get('/admin/dashboard');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('Pending Users'); // Adjust to match your dashboard content
    }

    public function test_admin_can_see_pending_users_on_dashboard()
    {
        $this->seed();
        $admin = User::factory()->create(['status' => 'approved']);
        $admin->assignRole('admin');
        $pendingUsers = collect();
        for ($i = 1; $i <= 3; $i++) {
            $user = User::factory()->create([
                'status' => 'pending',
                'name' => 'Test Pending',
                'email' => "pendinguser{$i}@example.com",
                'phone' => '1234567890',
                'address' => '123 Test St',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $user->assignRole('user');
            $pendingUsers->push($user);
        }
        $dashboard = $this->actingAs($admin)->get('/admin/dashboard?search=' . $pendingUsers->first()->email);
        $dashboard->assertStatus(200);
        $dashboard->assertSee($pendingUsers->first()->email);
    }

    public function test_admin_can_view_user_details()
    {
        $this->seed();
        $admin = User::factory()->create(['status' => 'approved']);
        $admin->assignRole('admin');
        $pendingUser = User::factory()->create(['status' => 'pending']);
        $pendingUser->assignRole('user');
        $response = $this->actingAs($admin)->get('/admin/users/' . $pendingUser->id);
        $response->assertStatus(200);
        $response->assertSee($pendingUser->email);
        $response->assertSee('Approve');
        $response->assertSee('Reject');
    }

    public function test_admin_can_approve_user_and_audit_log_is_created()
    {
        $this->seed();
        $admin = User::factory()->create(['status' => 'approved']);
        $admin->assignRole('admin');
        $pendingUser = User::factory()->create(['status' => 'pending']);
        $pendingUser->assignRole('user');
        $response = $this->actingAs($admin)->post('/admin/users/' . $pendingUser->id . '/approve');
        $response->assertRedirect();
        $pendingUser->refresh();
        $this->assertEquals('approved', $pendingUser->status);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $pendingUser->id,
            'admin_id' => $admin->id,
            'action' => 'approved',
        ]);
    }

    public function test_admin_can_reject_user_with_reason_and_audit_log_is_created()
    {
        $this->seed();
        $admin = User::factory()->create(['status' => 'approved']);
        $admin->assignRole('admin');
        $pendingUser = User::factory()->create(['status' => 'pending']);
        $pendingUser->assignRole('user');
        $response = $this->actingAs($admin)->post('/admin/users/' . $pendingUser->id . '/reject', [
            'reason' => 'Invalid documents',
        ]);
        $response->assertRedirect();
        $pendingUser->refresh();
        $this->assertEquals('rejected', $pendingUser->status);
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $pendingUser->id,
            'admin_id' => $admin->id,
            'action' => 'rejected',
            'reason' => 'Invalid documents',
        ]);
    }

    public function test_user_cannot_access_admin_dashboard()
    {
        $this->seed();
        $user = User::factory()->create(['status' => 'approved']);
        $user->assignRole('user');
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_dashboard()
    {
        $this->seed();
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }
} 