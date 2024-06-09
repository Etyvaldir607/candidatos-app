<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class UserSeeder extends Seeder
{
    /**
     * Amount.
     *
     * @var int
     */
    private $amount = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //The output
        //$output = new ConsoleOutput();
        //// creates a new progress bar (10 units)
        //$progressBar = new ProgressBar($output, $this->amount);
        //// starts and displays the progress bar
        //$progressBar->start();
        //User::factory($this->amount)->make()->each(function ($user) use ($progressBar) {
        //    // advances the progress bar 1 unit
        //    if ($user->save()) {
        //        $progressBar->advance();
        //    }
        //});
        //// ensures that the progress bar is at 100%
        //$progressBar->finish();

        $users = [
            [
                'name' => 'Manager user',
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'username' => 'user.manager',
                'last_login' => fake()->dateTime(new Carbon('yesterday')),
                'is_active' => fake()->boolean(3),
            ],
            [
                'name' => 'Agent user',
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'username' => 'user.agent',
                'last_login' => fake()->dateTime(new Carbon('yesterday')),
                'is_active' => fake()->boolean(3),
            ]
        ];

        $progressBar = $this->command->getOutput()->createProgressBar(count($users));

        foreach ($users as $user) {
            User::create($user);
            $progressBar->advance();
        }

        $progressBar->finish();

    }
}
