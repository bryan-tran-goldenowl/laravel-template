<?php

namespace Tests\Unit;


use App\Http\Controllers\Api\AuthController;
use Tests\TestCase;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Illuminate\Http\JsonResponse;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCreateUserSuccessfully()
    {

        $request = new RegisterRequest([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => '12345678',
            'password_confirm' => '12345678'
        ]);


        $userService = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'johndoe@example.com';
        $user->id = 500;
        $user->password = bcrypt('12345678');
        $userService->expects($this->once())
            ->method('signup')
            ->with($request)
            ->willReturn($user);


        $controller = new AuthController();
        $response = $controller->createUser($request, $userService);
        $this->assertEquals(['message' => 'User Created Successfully', 'id' => 500], json_decode($response->getContent(), true));

    }

}
