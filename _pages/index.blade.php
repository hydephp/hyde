@php($title = 'Latest Posts')
@extends('hyde::layouts.app')
@section('content')

<main id="content" class="mx-auto max-w-7xl py-12 px-8">
    <header class="lg:mb-12 xl:mb-16">
        <h1
        class="text-3xl text-left leading-10 tracking-tight font-extrabold sm:leading-none mb-8 md:mb-12 md:text-4xl md:text-center lg:text-5xl text-gray-700 dark:text-gray-200">
        Latest Posts</h1>
    </header>

    <div class="max-w-3xl mx-auto">
        @foreach(Hyde::getLatestPosts() as $post)
        @include('hyde::components.article-excerpt')
        @endforeach
    </div>
</main>

@endsection
