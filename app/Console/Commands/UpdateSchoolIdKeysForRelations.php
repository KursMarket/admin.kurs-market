<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\School;
use Illuminate\Console\Command;

class UpdateSchoolIdKeysForRelations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update-school-keys-for-relations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schools = School::all();

        $bar = $this->output->createProgressBar(count($schools));
        $bar->start();
        foreach ($schools as $school) {
            $courses = Course::query()->where('school_id', $school->user_id)->get();

            foreach ($courses as $course) {
                $course->update(['school_id' => $school->id]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->info('Update school keys finished. ' . "\n");

    }
}
