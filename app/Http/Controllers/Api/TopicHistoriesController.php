<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\HistoryCollection;

class TopicHistoriesController extends Controller
{
    public function index(Request $request, Topic $topic): HistoryCollection
    {
        $this->authorize('view', $topic);

        $search = $request->get('search', '');

        $histories = $topic
            ->histories()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryCollection($histories);
    }

    public function store(Request $request, Topic $topic): HistoryResource
    {
        $this->authorize('create', History::class);

        $validated = $request->validate([
            'prompt' => ['required', 'max:255', 'string'],
            'json' => ['required', 'max:255', 'string'],
            'section_id' => ['required', 'exists:sections,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $history = $topic->histories()->create($validated);

        return new HistoryResource($history);
    }
}
