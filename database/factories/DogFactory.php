<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        $ownerId = Owner::inRandomOrder()->limit(1)->get()[0]->id;
        return [
            'name' => $this->faker->name(),
            'owner_id' => $ownerId
        ];
    }

    
    public function create($attributes = [], ?Model $parent = null){
        $count = $this->state($attributes)->count;

        for ($i=0; $i < $count; $i++) {
            $ownerId = Owner::all()->random(1)[0]->id;
            $dogData[] = [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'name' => $this->faker->name,
                'owner_id' => $ownerId
            ];
        }


        $chunks = array_chunk($dogData, 50);

        foreach ($chunks as $chunk) {
            Dog::insert($chunk);
        }
    }
}
