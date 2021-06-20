<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

class DogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$ownerId = Owner::inRandomOrder()->limit(1)->get()[0]->id;
        $totalOwners = Owner::count();
        return [
            'name' => $this->faker->name(),
            'owner_id' => $this->faker->numberBetween(1,$totalOwners)
        ];
    }
}
