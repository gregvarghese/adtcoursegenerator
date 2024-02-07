<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseCollection;

class UserCoursesController extends Controller
{
    public function index(Request $request, User $user): CourseCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $courses = $user
            ->courses()
            ->search($search)
            ->latest()
            ->paginate();

        return new CourseCollection($courses);
    }

    public function store(Request $request, User $user): CourseResource
    {
        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
        ]);

        $course = $user->courses()->create($validated);

        return new CourseResource($course);
    }
}
