<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;


class StoreProfileTest extends TestCase
{
    public function setUp():void
    {
        parent::setUp();
        $this->actingAs(User::all()->last());
    }
    public function test_store_profile_validation()
    {
        $this->postJson(route('dashboard.profiles.store'), [])
            ->assertJsonValidationErrors(['name', 'email','country_id', 'phone', 'password','gender','role_id']);

        $this->postJson(route('dashboard.profiles.store'), [
            'name' => 'User',
            'email' => 'user.demo.com5',
            'country_id' => '1',
            'phone' => '123456',
            'role_id'=>'1',
            'gender' => User::MALE,
            'image' => UploadedFile::fake()->create('file.pdf'),
            'password' => 'password',
            'password_confirmation' => '123456',
        ])
            ->assertJsonValidationErrors(['email', 'password','image']);
    }

    function test_store_profile()
    {
        $response = $this->postJson(route('dashboard.profiles.store'), [
            'name' => 'User Test',
            'role_id'=>'1',
            'email' => 'user@demo.com',
            'country_id' => '1',
            'phone' => '123456',
            'password' => 'password',
            'type' => User::MODERATOR,
            'gender' => User::MALE,
            'image' => UploadedFile::fake()->image('avatar.jpg'),
            'password_confirmation' => 'password',
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure(['token']);
        $this->assertFileExists(User::find($response['data']['id'])->getFirstMedia('images')->getPath());
    }
}
