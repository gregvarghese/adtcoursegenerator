<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ChatGPT Prompt Generator</title>
	<!-- Include Bootstrap CSS from CDN -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<style>
        .container { margin-top: 20px; }
	</style>
</head>
<body>
<div class="container">
	<h1>Digital Agency Training Topic Generator</h1>
	<form action="{{ url('/chat') }}" method="POST" class="mt-4">
		@csrf
		<div class="mb-3">
			<label for="keyword" class="form-label">Keywords (each on a single line):</label>
			<textarea id="keyword" name="keyword" rows="10" cols="200" class="form-control"></textarea>
		</div>
		<div class="mb-3">
			<label for="promptSelection" class="form-label">Select Option:</label>
			<select id="promptSelection" class="form-select" name="prompt">
				<option value="">Select an option</option>
				<option value="Provide an easy-to-understand explanation for the digital marketing term {term}. It has to be at least two paragraphs, with three preferred as to why the term is important. Include a bullet point defining which category of marketing it falls under, 3 real-world examples and use cases, and 3 example platforms or tools a user can use. Real-world Examples and Tools/Platforms should be returned with an h2 heading and a list of 3 bulleted items under.">Generate Topic</option>
				<option value="Generate more detailed examples on how to accomplish {term}">Generate detailed examples:</option>
				<option value="Explain why {term} is not as often used compared to the popular term.">Explain why not used</option>
			</select>
		</div>
		<div class="mb-3">
			<label for="prompt" class="form-label">Prompt:</label>
			<textarea id="prompt" name="prompt-preview" rows="10" cols="200" class="form-control"></textarea>
		</div>
		<input type="submit" value="Submit" class="btn btn-primary">
	</form>
</div>

<!-- Include Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/js/bootstrap.bundle.min.js"></script>
<script>
	document.getElementById('keyword').addEventListener('input', function() {
		updatePrompt();
	});

	document.getElementById('promptSelection').addEventListener('change', function() {
		updatePrompt();
	});

	function updatePrompt() {
		const keyword = document.getElementById('keyword').value;
		const selectedOption = document.getElementById('promptSelection').value;
		document.getElementById('prompt').value = selectedOption.replace(/{term}/g, keyword);
	}
</script>
</body>
</html>
