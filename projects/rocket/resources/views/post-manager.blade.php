@extends('partials.layout')
@section('title', 'Manage Blog Post')
@section('content')
    <style>
		form {
			margin-top: 1rem;
		}
		form > header {
			padding-bottom: 0.5rem;
		}
		form > footer {
			padding-top: 0.5rem;
			display: flex;
			justify-content: space-between;
		}
		#markdown {
            font-family: monospace;
        }
		
    </style>
    <header>
        <h1>
            Manage Blog Post
        </h1>
        <p class="prose mx-auto">
            Here you can edit the Markdown content of your blog post.
            <br>
            You can use the plaintext Markdown editor below,
			or open it in your system editor.
        </p>
    </header>
    <section>
        <form action="" method="POST" class="mx-auto">
			<header>
				<label for="markdown">Blog Post Markdown:</label>
			</header>
            <textarea name="markdown" id="markdown" cols="70" rows="30">{{ $markdown }}</textarea>
			<footer>
				<div>
					<button onclick="openFile()" type="button" title="Open the file in your system default editor">Open File</button>
				</div>
				<div>
					<input type="reset" style="margin-right: 4px;">
					<input type="submit">
				</div>
			</footer>
		</form>
    </section>

	<script>
		function openFile() {
			// Make async fetch post request
			fetch('/fileapi/open', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json'
				},
				body: JSON.stringify({
					path: '{{ $localPath }}',
				})
			})
		}
	</script>


	@if($saved)
	<article id="savedToast" role="alert" aria-live="assertive" aria-atomic="true">
		<p>
			Your post has been saved! <span style="color: green;">✔</span>
		</p>
		<div id="toast-border-bar"></div>
	</article>
	<style>
		#savedToast {
			display: block;
			position: fixed;
			bottom: 1rem;
			right: 1rem;
			z-index: 1;
			color: black;
			padding: 0 1rem;
			background: lightgray;
			border-radius: 0.5rem;
			box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
			transition: opacity 0.5s;
			overflow: hidden;
		}
		#toast-border-bar {
			position: absolute;
			bottom: 0;
			left: 0;
			width: 100%;
			height: 4px;
			background: rgb(128, 128, 128);
			transition: width 2s linear;
		}
	</style>
	<script>
		// Remove query string from URL
		window.history.pushState({}, document.title, window.location.pathname);
		
		// Animate toast border bar
		setTimeout(function() {
			document.getElementById('toast-border-bar').style.width = '0';
		}, 0);
		
		setTimeout(function() {
			document.getElementById('savedToast').remove();
		}, 2000);
	</script>
	@endif
@endsection
