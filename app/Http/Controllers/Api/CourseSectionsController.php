<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Resources\SectionCollection;

class CourseSectionsController extends Controller
{
    public function index(Request $request, Course $course): SectionCollection
    {
        $this->authorize('view', $course);

        $search = $request->get('search', '');

        $sections = $course
            ->sections()
            ->search($search)
            ->latest()
            ->paginate();

        return new SectionCollection($sections);
    }

    public function store(Request $request, Course $course): SectionResource
    {
        $this->authorize('create', Section::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $section = $course->sections()->create($validated);

        return new SectionResource($section);
    }
}
