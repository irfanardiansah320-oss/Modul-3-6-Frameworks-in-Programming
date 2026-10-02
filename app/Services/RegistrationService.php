<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationService
{
    public function register(Activity $activity, array $data): Registration
    {
        // IC-01: hanya activity published
        if (!in_array($activity->status, ['published', 'Ongoing'], true)) {
            throw ValidationException::withMessages([
                'activity' => 'Pendaftaran hanya dibuka untuk kegiatan yang sudah dipublikasikan.',
            ]);
        }

        // IC-02: belum lewat waktu mulai
        if ($activity->activity_date && $activity->activity_date->isPast()) {
            throw ValidationException::withMessages([
                'activity' => 'Pendaftaran ditutup karena kegiatan sudah berlangsung atau lewat.',
            ]);
        }

        // IC-03: email belum terdaftar di activity yang sama
        $alreadyRegistered = Registration::where('activity_id', $activity->id)
            ->where('email', $data['email'])
            ->exists();

        if ($alreadyRegistered) {
            throw ValidationException::withMessages([
                'email' => 'Email ini sudah terdaftar pada kegiatan ini.',
            ]);
        }

        // IC-04: kapasitas belum penuh
        if ($activity->registered_count >= $activity->capacity) {
            throw ValidationException::withMessages([
                'activity' => 'Kapasitas kegiatan sudah penuh.',
            ]);
        }

        // IC-05 & IC-06: satu transaction untuk create + increment
        return DB::transaction(function () use ($activity, $data) {
            $registration = $activity->registrations()->create([
                'participant_name' => $data['participant_name'],
                'email' => $data['email'],
                'registered_at' => now(),
            ]);

            $activity->increment('registered_count');

            return $registration;
        });
    }
}
