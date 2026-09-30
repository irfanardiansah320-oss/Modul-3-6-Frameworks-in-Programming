<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Validation\ValidationException;

class ActivityService
{
    private const TRANSITIONS = [
        'draft' => ['draft', 'published'],
        'published' => ['published', 'completed'],
        'completed' => ['completed'],
        // Menjaga kompatibilitas jika baseline menggunakan Planned/Ongoing/Done:
        'Planned' => ['Planned', 'Ongoing'],
        'Ongoing' => ['Ongoing', 'Done'],
        'Done' => ['Done'],
    ];

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $nextStatus = $data['status'] ?? $activity->status;
        $this->ensureValidTransition($activity->status, $nextStatus);

        $activity->update($data);

        return $activity->refresh();
    }

    public function publish(Activity $activity): void
    {
        if (!in_array($activity->status, ['draft', 'Planned'], true)) {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan berstatus draft yang dapat dipublikasikan.',
            ]);
        }

        // BR-05: Cek kelengkapan data sebelum dipublikasikan
        if (empty($activity->code) || empty($activity->title) || empty($activity->category_id)) {
            throw ValidationException::withMessages([
                'status' => 'Gagal publikasi! Kategori, kode, dan judul wajib diisi.',
            ]);
        }

        $activity->update(['status' => 'published']);
    }

    public function complete(Activity $activity): void
    {
        if (!in_array($activity->status, ['published', 'Ongoing'], true)) {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan berstatus published yang dapat diselesaikan.',
            ]);
        }

        $activity->update(['status' => 'completed']);
    }

    private function ensureValidTransition(string $current, string $next): void
    {
        $allowed = self::TRANSITIONS[$current] ?? [];

        if (!in_array($next, $allowed, true)) {
            throw ValidationException::withMessages([
                'status' => "Transisi status {$current} ke {$next} tidak diizinkan."
            ]);
        }
    }
}