<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryResource;
use App\Http\Resources\HistoryCollection;

class UserHistoriesController extends Controller
{
    public function index(Request $request, User $user): HistoryCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $histories = $user
            ->histories()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryCollection($histories);
    }

    public function store(Request $request, User $user): HistoryResource
    {
        $this->authorize('create', History::class);

        $validated = $request->validate([
            'prompt' => ['required', 'max:255', 'string'],
            'json' => ['required', 'max:255', 'string'],
            'topic_id' => ['required', 'exists:topics,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $history = $user->histories()->create($validated);

        return new HistoryResource($history);
    }
}
