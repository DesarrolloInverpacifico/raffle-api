<?php

namespace Database\Seeders;

use App\Models\People;
use App\Models\Raffle;
use App\Models\RaffleCriteria;
use App\Models\RaffleParticipant;
use App\Models\RafflePrize;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'username'  => 'admin',
            'password'  => bcrypt('password'),
        ]);

        $people = People::factory()->count(10)->create();

        Raffle::factory()->count(1)->create()->each(function (Raffle $raffle) use ($people) {

            $criterias = RaffleCriteria::factory()->count(random_int(1, 4))->create([
                'raffle_id'         =>  $raffle->id,
                'prize'             =>  random_int(5000, 100000),
                'position'          =>  1
            ]);


            // Create Participant
            $ids = $people->pluck('id');
            $raffle->people()->sync($ids->random(random_int(1, count($ids))));

            $amountWinners = $ids->random(random_int(1, count($criterias)));
            // Update Winner
            foreach ($amountWinners as $key => $idWinner) {
                $raffle->people()->updateExistingPivot($idWinner, [
                    'is_winner' =>  true,
                    'is_active' =>  true
                ]);
            }
        });
    }
}
