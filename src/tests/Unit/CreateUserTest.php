<?php

namespace Tests\Unit;


use App\Http\Controllers\Api\AuthController;
use Tests\TestCase;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
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


        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $user = new User();
        $user->name = 'John Doe';
        $user->email = 'johndoe@example.com';
        $user->id = 500;
        $user->password = bcrypt('12345678');
        $userRepository->expects($this->once())
            ->method('signup')
            ->with($request)
            ->willReturn($user);


        $controller = new AuthController();
        $response = $controller->createUser($request, $userRepository);
        $this->assertEquals(['message' => 'User Created Successfully', 'id' => 500], json_decode($response->getContent(), true));

    }

}
