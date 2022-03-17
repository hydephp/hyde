{{-- The Documentation Page Layout based on Laradocgen --}}
@extends('layouts.app')
@section('content')
@php($withoutNavigation = true)
<aside id="documentation-sidebar" class="w-64 h-screen hidden md:flex flex-col fixed top-0 left-0 shadow-xl overflow-hidden">
	@include('components.docs.sidebar')
</aside>
<main id="documentation-content" class="mx-auto max-w-7xl py-16 px-8 md:absolute md:left-72 xl:left-80">
	@include('components.docs.content')
</main>

@endsection
