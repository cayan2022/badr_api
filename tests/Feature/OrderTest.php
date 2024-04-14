<?php
//order.store
use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\Source;
use App\Models\User;
use Illuminate\Support\Arr;

it('will create a new user if not no user with requested email,phone exists before', function () {
    $data = [
        'name' => Faker\Factory::create()->name,
        'category_id' => Category::factory()->create()->id,
        'source_id' => Source::factory()->create()->id,
        'branch_id' => Branch::factory()->create()->id,
        'email' => 'test@gmail.com',
        'phone' => '01111221111'
    ];

    $this->assertDatabaseMissing(User::class, Arr::only($data, ['phone', 'email']));

    $response = $this->postJson(route('site.order.store'), $data);

    $response->assertStatus(201);
    $this->assertDatabaseHas(User::class, Arr::only($data, ['phone', 'email']));

    $user = User::query()->where(['phone' => $data['phone'], 'email' => $data['email']])->first();
    $this->assertDatabaseHas(
        Order::class,
        Arr::only($data, ['category_id', 'source_id', 'branch_id']) + ['user_id' => $user->id]
    );
});


it('can create order with exists user email and phone', function () {
    $user = User::factory([
                              'email' => 'test@gmail.com',
                              'phone' => '01111221111'
                          ])->create();
    $data = [
        'name' => Faker\Factory::create()->name,
        'category_id' => Category::factory()->create()->id,
        'source_id' => Source::factory()->create()->id,
        'branch_id' => Branch::factory()->create()->id,
        'email' => $user->email,
        'phone' => $user->phone
    ];
    $response = $this->postJson(route('site.order.store'), $data);

    $response->assertStatus(201);

    $findUsers=User::query()->where(['phone' => $data['phone'], 'email' => $data['email']])->get();
    $this->assertCount(1, $findUsers);
    $this->assertDatabaseCount(Order::class, 1);


});

test('when create order with exists user it update user data', function () {
    $user = User::factory([
                              'email' => 'test@gmail.com',
                              'phone' => '01111221111'
                          ])->create();

    $data = [
        'name' => Faker\Factory::create()->name,
        'category_id' => Category::factory()->create()->id,
        'source_id' => Source::factory()->create()->id,
        'branch_id' => Branch::factory()->create()->id,
        'email' => $user->email,
        'phone' => '01200004141'
    ];
    $response = $this->postJson(route('site.order.store'), $data);

    $response->assertStatus(201);
    $findUsers=User::query()->where(['phone' => $data['phone'], 'email' => $data['email']])->get();
    $this->assertCount(1, $findUsers);

    $user2=[
        'email' => 'newemail@gmail.com',
        'phone' => '01200004141'
    ];

    $data=array_merge($data,$user2) ;

    $response = $this->postJson(route('site.order.store'), $data);

    $response->assertStatus(201);
    $findUsers=User::query()->where(['phone' => $data['phone'], 'email' => $data['email']])->get();
    $this->assertCount(1, $findUsers);
});



