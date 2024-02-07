<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\HistoryCollection;

class CourseHistoriesController extends Controller
{
    public function index(Request $request, Course $course): HistoryCollection
    {
        $this->authorize('view', $course);

        $search = $request->get('search', '');

        $histories = $course
            ->histories()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryCollection($histories);
    }

    public function store(Request $request, Course $course): HistoryResource
    {
        $this->authorize('create', History::class);

        $validated = $request->validate([
            'prompt' => ['required', 'max:255', 'string'],
            'json' => ['required', 'max:255', 'string'],
            'topic_id' => ['required', 'exists:topics,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $history = $course->histories()->create($validated);

        return new HistoryResource($history);
    }
}
