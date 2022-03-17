<article class="mt-4 mb-8">
	<footer>
		@isset($post->matter['date'])
		<span class="opacity-75">
			{{ date('M jS, Y', strtotime($post->matter['date'])) }},
		</span>
		@endisset
		@isset($post->matter['author'])
		<span class="opacity-75">by</span>
		{{ $post->matter['author'] }}
		@endisset
	</footer>
	<header>
		<a href="posts/{{ $post->matter['slug'] }}.html">
			<h3 class="text-2xl font-bold opacity-75 hover:opacity-100">{{ $post->matter['title'] }}</h3>
		</a>
	</header>
	<div>
		<p class="leading-relaxed my-1">
			@isset($post->matter['description'])
			{{ $post->matter['description'] }}
			@endisset
		</p>
		<a href="posts/{{ $post->matter['slug'] }}.html" class="text-indigo-500 hover:underline font-medium">Read more</a>
	</div>	
</article>