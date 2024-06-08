<?php

namespace Database\Seeders;

use App\Models\Applicant;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ApplicantSeeder extends Seeder
{
    /**
     * Amount.
     *
     * @var int
     */
    private $amount = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // The output
        $output = new ConsoleOutput();

        // creates a new progress bar (10 units)
        $progressBar = new ProgressBar($output, $this->amount);

        // starts and displays the progress bar
        $progressBar->start();

        Applicant::factory($this->amount)->make()->each(function ($applicant) use ($progressBar) {
            // advances the progress bar 1 unit
            if ($applicant->save()) {
                $progressBar->advance();
            }
        });

        // ensures that the progress bar is at 100%
        $progressBar->finish();
    }
}
