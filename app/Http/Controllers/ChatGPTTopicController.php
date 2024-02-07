<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class ChatGPTTopicController extends Controller
{
	public function index()
	{
		return view('chat.index');
	}

	public function store(Request $request)
	{
		$apiKey = env('OPENAI_API_KEY'); // Make sure to set your OpenAI API Key in your .env file
		$endpoint = "https://api.openai.com/v1/chat/completions";

		$keywords = $request->keyword;
		$prompt = $request->prompt;
		$topics = [];
		$prompts = [];

//		if (strpos($keywords, "\n") !== false) {
//			// If it does, split it into an array by new line
		$keywords = explode("\n", $keywords);

		// Then loop through each keyword
		foreach ($keywords as $keyword) {
			// Trim the keyword to remove leading/trailing whitespaces
			$keyword = trim($keyword);

			$prompt1 = str_replace('{term}', $keyword, $prompt);
			$prompts[] = $prompt1;


//			dd($prompt, $keyword, $keywords);

			$response = Http::withHeaders([
				'Authorization' => 'Bearer ' . $apiKey,
				'Content-Type' => 'application/json',
			])->post($endpoint, [
				'model' => 'gpt-4', // or another model you have access to
				'messages' => [
					['role' => 'system', 'content' => 'Our company name is Digital Agency Training. Our main product helps different departments to understand the different aspects of digital marketing. We would like to create an online course about digital marketing. The main goal of the course is to understand all aspects of digital marketing. I evaluate the complexity of the planned course as average. We target learners who are beginners in digital marketing. Please help us design the course.
Students will be able to explain the key concepts and principles of digital marketing
Students will be able to identify and analyze the key trends in digital marketing
Students will be able to apply digital marketing knowledge to real-world scenarios. '],
					['role' => 'user', 'content' => $prompt1],
				],
			]);

			// Get the raw body for JSON display
			$rawResponse = (string)$response->getBody();
			$body = json_decode($rawResponse, true);
			$chatResponse = $body['choices'][0]['message']['content'] ?? 'No response';

			// Prepare markdown (simply the chat response for this example)
			$markdownResponse = htmlspecialchars($chatResponse);

			// Convert markdown to a simple HTML for demonstration
			$mdRenderer = new MarkdownRenderer();
			$htmlResponse = $mdRenderer->toHtml($markdownResponse);

			$topics[] = Topic::create([
				'title' => $keyword,
				'prompt' => $prompt,
				'json' => $rawResponse,
				'markdown' => $markdownResponse,
				'html' => $htmlResponse,
				'complete' => false,
				'user_id' => 1,
				'section_id' => 1,
				'course_id' => 1,
			]);
		}

//dd($prompts);

		// Pass all formats to the view
		return view('chat.result', [
			'topics' => $topics,
//			'json' => $rawResponse,
//			'markdown' => $markdownResponse,
//			'html' => $htmlResponse,
//			'title' => $request->keyword,
		]);

	}
}
