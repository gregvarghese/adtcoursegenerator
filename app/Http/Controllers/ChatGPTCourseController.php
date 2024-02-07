<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatGPTCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		$topic = '"Empathy in Design" to educate designers in how to think about different audiences and not just making things pretty';
        $outline_prompt = "Generate a detailed outline for a beginner's course in digital marketing covering $topic, covering all key concepts and principles, including trends and real-world applications. Include module titles and lesson topics.";
		$intoduction_prompt = "Write an introduction script for a module on $topic that introduces beginners to the main concepts and explains why they are important in the digital marketing landscape.";


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
