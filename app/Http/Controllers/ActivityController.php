<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use App\Services\PosterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function __construct(
        private ActivityService $activityService,
        private PosterService $posters,
    ) {}

    private function categoryOptions()
    {
        return Category::ordered()->get();
    }

    public function index(): View
    {
        $activities = Activity::with('category') // Eager loading untuk cegah N+1
            ->filter(request(['search', 'category_id', 'status', 'sort']))
            ->paginate(10)
            ->withQueryString(); // Mempertahankan parameter URL saat pindah halaman

        $categories = $this->categoryOptions();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function create(): View
    {
        return view('activities.create', [
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['poster']);

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $this->posters->store($request->file('poster'));
        }

        $activity = $this->activityService->create($data);

        return redirect('/activities/'.$activity->id)
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        return view('activities.edit', [
            'activity'   => $activity,
            'categories' => $this->categoryOptions(),
        ]);
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        $data = $request->validated();
        unset($data['poster']);

        $oldPoster = $activity->poster_path;
        $hasNewPoster = $request->hasFile('poster');

        if ($hasNewPoster) {
            $data['poster_path'] = $this->posters->store($request->file('poster'));
        }

        $this->activityService->update($activity, $data);

        // File lama dihapus setelah file baru tersimpan dan database diperbarui
        if ($hasNewPoster) {
            $this->posters->delete($oldPoster);
        }

        return redirect('/activities/'.$activity->id)
            ->with('success', 'Data diperbarui.');
    }

    public function publish(Activity $activity): RedirectResponse
    {
        $this->activityService->publish($activity);

        return back()->with('success', "Kegiatan '{$activity->title}' berhasil dipublikasikan.");
    }

    public function complete(Activity $activity): RedirectResponse
    {
        $this->activityService->complete($activity);

        return back()->with('success', "Kegiatan '{$activity->title}' telah selesai.");
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete(); // soft delete, file poster sengaja tidak dihapus

        return redirect('/activities')
            ->with('success', 'Kegiatan berhasil dipindahkan ke sampah.');
    }

    public function trash(): View
    {
        $activities = Activity::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(10);

        return view('activities.trash', compact('activities'));
    }

    public function restore(Activity $activity): RedirectResponse
    {
        $activity->restore();

        return redirect()->route('activities.index')
            ->with('success', "Kegiatan '{$activity->title}' berhasil dipulihkan.");
    }
}