<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Http\Resources\TopicCollection;

class UserTopicsController extends Controller
{
    public function index(Request $request, User $user): TopicCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $topics = $user
            ->topics()
            ->search($search)
            ->latest()
            ->paginate();

        return new TopicCollection($topics);
    }

    public function store(Request $request, User $user): TopicResource
    {
        $this->authorize('create', Topic::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'prompt' => ['required', 'max:255', 'string'],
            'json' => ['required', 'max:255', 'string'],
            'html' => ['required', 'max:255', 'string'],
            'complete' => ['required', 'boolean'],
            'section_id' => ['required', 'exists:sections,id'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $topic = $user->topics()->create($validated);

        return new TopicResource($topic);
    }
}
