<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Results</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>

</head>
<body>
<div class="container my-5">
	<h1 class="mb-4">Results</h1>

	<div class="mb-3">
		<a href="/chat" class="btn btn-primary">Generate New Topic</a>
	</div>


	@foreach($topics as $topic)
		<div class="mb-3">
			<label for="title-{{$loop->index}}" class="form-label">Title:</label>
			<input type="text" id="title-{{$loop->index}}" class="form-control" rows="5" value="{{ $topic->title }}" readonly/>
			<button class="btn btn-primary mt-2" onclick="copyToClipboard('#title-{{$loop->index}}')">Copy title</button>
		</div>

		<div class="mb-3">
			<label for="rawJson-{{$loop->index}}" class="form-label">Raw JSON:</label>
			<textarea id="rawJson-{{$loop->index}}" class="form-control" rows="5" readonly>{{ $topic->json }}</textarea>
			<button class="btn btn-primary mt-2" onclick="copyToClipboard('#rawJson-{{$loop->index}}')">Copy JSON</button>
		</div>

		<div class="mb-3">
			<label for="markdown-{{$loop->index}}" class="form-label">Markdown Preview:</label>
			<textarea id="markdown-{{$loop->index}}" class="form-control" rows="5" readonly>{{ $topic->markdown }}</textarea>
			<button class="btn btn-primary mt-2" onclick="copyToClipboard('#markdown-{{$loop->index}}')">Copy Markdown</button>

			<x-markdown theme="github-dark">
				{{ $topic->markdown }}
			</x-markdown>

		</div>

		<div class="mb-3">
			<label for="htmlContent-{{$loop->index}}" class="form-label">HTML:</label>
			<textarea id="htmlContent-{{$loop->index}}" class="form-control" rows="5" readonly>{{ $topic->html }}</textarea>
			<button class="btn btn-primary mt-2" onclick="copyToClipboard('#htmlContent-{{$loop->index}}')">Copy HTML</button>
		</div>

		<div class="mb-3">
			<hr class="hr hr-blurry" />
		</div>
	@endforeach

	<div class="mb-3">
		<a href="/chat" class="btn btn-primary">Generate New Topic</a>
	</div>
</div>

<script>
	function copyToClipboard(elementId) {
		const copyText = document.querySelector(elementId);
		copyText.select();
		document.execCommand('copy');
	}

	ClassicEditor
		.create(document.querySelector('#htmlContent'))
		.catch(error => {
			console.error(error);
		});
</script>
</body>
</html>
