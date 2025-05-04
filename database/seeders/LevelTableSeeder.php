<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use LevelUp\Experience\Models\Level;
use stdClass;

class LevelTableSeeder extends Seeder
{
    public function run(): void
    {
        $jsonDataFile = File::get(database_path('data/levels.json'));

        /** @var stdClass[] $labels */
        $levels = json_decode($jsonDataFile);

        collect($levels)->each(function (stdClass $level): void {
            Level::create(attributes: ['level' => $level->level, 'next_level_experience' => $level->next_level_experience]);
        });
    }
}
