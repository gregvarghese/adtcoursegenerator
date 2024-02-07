<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\HistoryCollection;

class SectionHistoriesController extends Controller
{
    public function index(Request $request, Section $section): HistoryCollection
    {
        $this->authorize('view', $section);

        $search = $request->get('search', '');

        $histories = $section
            ->histories()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryCollection($histories);
    }

    public function store(Request $request, Section $section): HistoryResource
    {
        $this->authorize('create', History::class);

        $validated = $request->validate([
            'prompt' => ['required', 'max:255', 'string'],
            'json' => ['required', 'max:255', 'string'],
            'topic_id' => ['required', 'exists:topics,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $history = $section->histories()->create($validated);

        return new HistoryResource($history);
    }
}
