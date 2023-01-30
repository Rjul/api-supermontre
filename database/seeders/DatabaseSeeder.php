<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

         \App\Models\User::factory()->create([
             'name'              => 'admin',
             'email'             => 'admin@admin.com',
             'email_verified_at' => now(),
             'password'          => Hash::make('password'), // password
             'remember_token'    => Str::random(10),
             'role'              => 'admin'
         ]);
        Category::factory(10)->create();
        Product::factory(100)->create();

        \App\Models\User::factory(10)
//            ->hasAttached(Product::query()->limit(10)->get())
            ->create();

        ProductUser::factory(100)->state(new Sequence(
            fn ($sequence) => [
                'user_id' => User::all()->random()->id,
                'product_id' => Product::all()->random()->id,
                'quantity' => fake()->numberBetween(1,4)
            ],
        ))->create();


    }
}
