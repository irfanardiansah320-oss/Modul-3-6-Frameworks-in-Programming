<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Activity::query()->insert([
            [
                'title' => 'Workshop Git Dasar',
                'description' => 'Latihan kolaborasi repository.',
                'activity_date' => '2026-10-05',
                'category' => 'Workshop',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seminar Web Quality',
                'description' => 'Pengenalan maintainability dan testing.',
                'activity_date' => '2026-10-12',
                'category' => 'Seminar',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Praktikum Laravel Basic',
                'description' => 'Membangun Activity Manager v1.',
                'activity_date' => '2026-09-21',
                'category' => 'Praktikum',
                'status' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Kajian Rutin Prodi',
                'description' => 'Diskusi materi semester berjalan.',
                'activity_date' => '2026-09-14',
                'category' => 'Kajian',
                'status' => 'Done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Persiapan UTS',
                'description' => 'Review materi sebelum ujian tengah semester.',
                'activity_date' => '2026-10-20',
                'category' => 'Akademik',
                'status' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
