<?php

namespace Database\Factories;

use App\Modules\User\Enums\RoleUserEnum;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    protected $model = User::class;

    public function definition(): array
    {
        return [

            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),

            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),

            'role' => RoleUserEnum::admin,
            'auth' => true,

            'first_name' => fake()->name(),
            'last_name' => fake()->firstName(),
            'father_name' => fake()->firstNameMale(),

            'email_confirmed_at' => now(),
            'phone_confirmed_at' => now(),

            'personal_area_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
