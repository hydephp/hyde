@extends('partials.layout')
@section('title', 'Manage Blog Post')
@section('content')
    <style>
		label {
			font-size: 90%;
		}
    </style>
    <header>
        <h1>
            Create new blog post
        </h1>
        <p class="prose mx-auto">
			Here you can create a new blog post!

			To keep a similar flow to the HydeCLI process,
			we do this in two steps. First, please fill out
			the form below to create the front matter metadata.
			
			Then, you will be redirected to the edit page where
			you can write the actual Markdown content of your post.

			In essence, this form is a wrapper for the
			<code>php hyde make:post</code> command.
			Only the post title is required.
		</p>
    </header>
    <section>
        <form action="" method="POST" class="mx-auto">
			<div class="small-vertical-spacing">
				<label for="title">What is the title of the post? <sup>(required)</sup></label>
				<input type="text" name="title" id="title" value="{{ request()->old('title') }}" required placeholder="e.g. My New Post">
				<small class="block">Will be used to generate the slug/filename.</small>
			</div>

			<div class="small-vertical-spacing">
				<label for="description">Write a short post excerpt/description</label>
				<input type="text" name="description" id="description" value="{{ request()->old('description') }}" placeholder="e.g. This is my new post">
			</div>

			<div class="small-vertical-spacing">
				<label for="author">What is your (the author's) name?</label>
				<input type="text" name="author" id="author" value="{{ request()->old('author') }}" placeholder="e.g. John Doe">
			</div>

			<div class="small-vertical-spacing">
				<label for="category">What is the primary category of the post?</label>
				<input type="text" name="category" id="category" value="{{ request()->old('category') }}" placeholder="e.g. News">
			</div>

			<div class="small-vertical-spacing">
				<input type="submit">
			</div>
		</form>
    </section>
@endsection
