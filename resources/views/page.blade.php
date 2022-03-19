{{-- The Markdown Page Layout --}}
@extends('layouts.app')
@section('content')

<main class="mx-auto max-w-7xl py-16 px-8 lg:mt-8">
	<article class="prose mx-auto max-w-5xl">
		{!! $markdown !!}
	</article>
</main>

@endsection
