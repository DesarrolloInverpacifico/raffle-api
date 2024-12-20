<?php

namespace Database\Seeders;

use App\Models\Raffle;
use App\Models\RaffleCriteria;
use App\Models\RaffleParticipant;
use App\Models\RafflePrize;
use App\Models\User;
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

        Raffle::factory()->count(1)->create()->each(function (Raffle $raffle) {

            // Create Prize
            // $prizes = RafflePrize::factory()->count(random_int(1, 4))->create([
            //     'raffle_id' =>  $raffle->id
            // ]);
            // $raffle->rafflePrizes()->saveMany($prizes);

            // Create Criteria
            // $positions = count($prizes);

            $criterias = RaffleCriteria::factory()->count(random_int(1, 4))->create([
                'raffle_id'         =>  $raffle->id,
                'prize'             =>  random_int(5000, 100000),
                'position'          =>  1
            ]);


            // Create Participant
            $participants = RaffleParticipant::factory()->count(50)->create([
                'raffle_id' =>  $raffle->id
            ]);

            // Run Raffle
            $winners = $participants->random(count($criterias));

            // Update Winner
            foreach ($winners as $key => $winner) {
                $winner->update([
                    'is_winner'         =>  true,
                    'won_at'            =>  \Carbon\Carbon::now()
                ]);
            }
        });
    }
}
