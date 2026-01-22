<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            [
                'psychologist_id' => 1,
                'day' => 'Senin',
                'start_time' => '09:00',
                'end_time' => '17:00',
                'is_available' => true,
            ],
            [
                'psychologist_id' => 1,
                'day' => 'Selasa',
                'start_time' => '10:00',
                'end_time' => '16:00',
                'is_available' => true,
            ],
            [
                'psychologist_id' => 2,
                'day' => 'Rabu',
                'start_time' => '08:00',
                'end_time' => '14:00',
                'is_available' => true,
            ],
            [
                'psychologist_id' => 2,
                'day' => 'Kamis',
                'start_time' => '13:00',
                'end_time' => '19:00',
                'is_available' => true,
            ],
            [
                'psychologist_id' => 3,
                'day' => 'Jumat',
                'start_time' => '09:00',
                'end_time' => '15:00',
                'is_available' => true,
            ],
            [
                'psychologist_id' => 4,
                'day' => 'Senin',
                'start_time' => '14:00',
                'end_time' => '20:00',
                'is_available' => true,
            ],
            [
                'psychologist_id' => 4,
                'day' => 'Rabu',
                'start_time' => '10:00',
                'end_time' => '16:00',
                'is_available' => true,
            ],
            [
                'psychologist_id' => 5,
                'day' => 'Selasa',
                'start_time' => '08:00',
                'end_time' => '14:00',
                'is_available' => true,
            ],
            [
                'psychologist_id' => 5,
                'day' => 'Kamis',
                'start_time' => '15:00',
                'end_time' => '21:00',
                'is_available' => true,
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}
