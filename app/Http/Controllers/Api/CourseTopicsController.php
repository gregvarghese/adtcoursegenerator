<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Http\Resources\TopicCollection;

class CourseTopicsController extends Controller
{
    public function index(Request $request, Course $course): TopicCollection
    {
        $this->authorize('view', $course);

        $search = $request->get('search', '');

        $topics = $course
            ->topics()
            ->search($search)
            ->latest()
            ->paginate();

        return new TopicCollection($topics);
    }

    public function store(Request $request, Course $course): TopicResource
    {
        $this->authorize('create', Topic::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'prompt' => ['required', 'max:255', 'string'],
            'json' => ['required', 'max:255', 'string'],
            'html' => ['required', 'max:255', 'string'],
            'complete' => ['required', 'boolean'],
            'section_id' => ['required', 'exists:sections,id'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $topic = $course->topics()->create($validated);

        return new TopicResource($topic);
    }
}
