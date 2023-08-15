<?php

namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    protected $user;
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'password' => Hash::make('abc123'),
        ]);
    }


    /** @test */
    public function ReturnsTokenOnSuccessfulLogin()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 'abc123',
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);
        $this->assertTrue(isset($response->json()['data']['token']));
    }

    /** @test */
    public function ReturnsErrorOnIncorrectPassword()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => $this->user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertUnauthorized();
        $response->assertJson(['success' => false]);
    }

    /** @test */
    public function ReturnsErrorOnUnknownUser()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'unknownuser@example.com',
            'password' => 'password',
        ]);

        $response->assertUnauthorized();
        $response->assertJson(['success' => false]);
    }
}
