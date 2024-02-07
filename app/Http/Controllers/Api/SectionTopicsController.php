<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Http\Resources\TopicCollection;

class SectionTopicsController extends Controller
{
    public function index(Request $request, Section $section): TopicCollection
    {
        $this->authorize('view', $section);

        $search = $request->get('search', '');

        $topics = $section
            ->topics()
            ->search($search)
            ->latest()
            ->paginate();

        return new TopicCollection($topics);
    }

    public function store(Request $request, Section $section): TopicResource
    {
        $this->authorize('create', Topic::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'prompt' => ['required', 'max:255', 'string'],
            'json' => ['required', 'max:255', 'string'],
            'html' => ['required', 'max:255', 'string'],
            'complete' => ['required', 'boolean'],
            'course_id' => ['required', 'exists:courses,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $topic = $section->topics()->create($validated);

        return new TopicResource($topic);
    }
}
