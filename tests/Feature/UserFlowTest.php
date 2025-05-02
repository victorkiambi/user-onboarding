<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration_assigns_role_and_stores_files()
    {
        $this->seed();
        Storage::fake('public');

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'phone' => '1234567890',
            'address' => '123 Test St',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_photo' => UploadedFile::fake()->image('profile.jpg'),
            'id_front' => UploadedFile::fake()->image('id_front.jpg'),
            'id_back' => UploadedFile::fake()->image('id_back.jpg'),
        ]);

        $response->assertRedirect('/login');
        $this->assertGuest();

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('pending', $user->status);
        $this->assertTrue($user->hasRole('user'));
        Storage::disk('public')->assertExists($user->profile_photo);
        Storage::disk('public')->assertExists($user->id_front);
        Storage::disk('public')->assertExists($user->id_back);
    }

    public function test_registration_fails_with_missing_required_fields()
    {
        $this->seed();
        Storage::fake('public');
        $response = $this->post('/register', []);
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'address', 'password', 'profile_photo', 'id_front', 'id_back']);
    }

    public function test_registration_fails_with_duplicate_email()
    {
        $this->seed();
        Storage::fake('public');
        User::factory()->create(['email' => 'dupe@example.com']);
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'dupe@example.com',
            'phone' => '1234567890',
            'address' => '123 Test St',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_photo' => UploadedFile::fake()->image('profile.jpg'),
            'id_front' => UploadedFile::fake()->image('id_front.jpg'),
            'id_back' => UploadedFile::fake()->image('id_back.jpg'),
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_registration_fails_with_password_mismatch()
    {
        $this->seed();
        Storage::fake('public');
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'mismatch@example.com',
            'phone' => '1234567890',
            'address' => '123 Test St',
            'password' => 'password',
            'password_confirmation' => 'notmatching',
            'profile_photo' => UploadedFile::fake()->image('profile.jpg'),
            'id_front' => UploadedFile::fake()->image('id_front.jpg'),
            'id_back' => UploadedFile::fake()->image('id_back.jpg'),
        ]);
        $response->assertSessionHasErrors(['password']);
    }

    public function test_registration_fails_with_large_file()
    {
        $this->seed();
        Storage::fake('public');
        $largeFile = UploadedFile::fake()->create('large.jpg', 3000, 'image/jpeg');
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'largefile@example.com',
            'phone' => '1234567890',
            'address' => '123 Test St',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_photo' => $largeFile,
            'id_front' => UploadedFile::fake()->image('id_front.jpg'),
            'id_back' => UploadedFile::fake()->image('id_back.jpg'),
        ]);
        $response->assertSessionHasErrors(['profile_photo']);
    }

    public function test_registration_fails_with_non_image_file()
    {
        $this->seed();
        Storage::fake('public');
        $notImage = UploadedFile::fake()->create('notimage.pdf', 100, 'application/pdf');
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'notimage@example.com',
            'phone' => '1234567890',
            'address' => '123 Test St',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_photo' => $notImage,
            'id_front' => UploadedFile::fake()->image('id_front.jpg'),
            'id_back' => UploadedFile::fake()->image('id_back.jpg'),
        ]);
        $response->assertSessionHasErrors(['profile_photo']);
    }

    public function test_approved_user_can_login_and_is_redirected_to_user_dashboard()
    {
        $this->seed();
        $user = \App\Models\User::factory()->create([
            'status' => 'approved',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_pending_user_cannot_login_and_sees_feedback()
    {
        $this->seed();
        $user = \App\Models\User::factory()->create([
            'status' => 'pending',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHas('status'); // Should have feedback message
        $this->assertGuest();
    }

    public function test_no_user_is_redirected_to_dashboard()
    {
        $this->seed();
        $user = \App\Models\User::factory()->create([
            'status' => 'approved',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/user/dashboard');
        $this->assertNotEquals('/dashboard', $response->headers->get('Location'));
    }
} 