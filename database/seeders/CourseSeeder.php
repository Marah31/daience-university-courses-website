<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use Illuminate\Support\Facades\File;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/courses.json');

        if (!File::exists($path)) {
            $this->command->error('courses.json file not found!');
            return;
        }

        $courses = json_decode(File::get($path), true);

        foreach ($courses as $course) {
            Course::updateOrCreate(
                ['ref_code' => $course['ref_code']],
                $course
            );
        }

        $this->command->info('Courses seeded successfully!');
    }
}
