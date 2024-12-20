<?php

namespace Database\Factories;

use App\Models\RaffleParticipant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RaffleParticipant>
 */
class RaffleParticipantFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = RaffleParticipant::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                      =>  $this->faker->name(),
            'email'                     =>  $this->faker->safeEmail(),
            'identification_number'     =>  $this->faker->randomNumber(7),
            'is_winner'                 =>  false,
            'won_at'                    =>  null,
            'raffle_id'                 =>  null,
        ];
    }
}
