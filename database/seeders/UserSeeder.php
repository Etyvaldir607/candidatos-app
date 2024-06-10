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
            $user_created = User::create($user);

            switch ($user_created->username) {
                case 'user.manager':
                    $user_created->assignRole('manager');
                    break;

                case 'user.agent':
                    $user_created->assignRole('agent');
                    break;

                default:
                    # code...
                    break;
            }

            $progressBar->advance();
        }

        $progressBar->finish();

    }
}
