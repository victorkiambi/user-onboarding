<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $this->seed();

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'address' => '123 Test St',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_photo' => UploadedFile::fake()->image('profile.jpg'),
            'id_front' => UploadedFile::fake()->image('id_front.jpg'),
            'id_back' => UploadedFile::fake()->image('id_back.jpg'),
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login', absolute: false));
        $response->assertSessionHas('status', 'Your account is under review. You will be notified once approved.');
    }
}
