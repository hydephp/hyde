@php
	$links = Hyde\Framework\Actions\GeneratesNavigationMenu::getNavigationLinks($currentPage);
	$homeRoute = ($links[array_search('Home', array_column($links, 'title'))])['route'] ?? 'index.html';
@endphp

<nav id="main-navigation" class="flex flex-row items-center justify-between w-full h-16 p-4 overflow-hidden shadow-lg sm:shadow-xl md:shadow-none z-20" aria-label="Primary Navigation Menu">
	<header id="navigation-brand">
		<a href="{{ $homeRoute }}" class="font-bold px-4">
			{{ config('hyde.name', 'HydePHP') }}
		</a>
	</header>

	<button class="navigation-toggle-button md:hidden" title="Open navigation menu" onClick="showNavigation()">
		<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
	</button>

	<ul id="desktop-navigation-links" class="hidden md:flex">
		@foreach ($links as $item)
			<li>
				@if($item['current'])
					<a href="{{ $item['route'] }}" aria-current="page" class="current">{{ $item['title'] }}</a>
				@else
					<a href="{{ $item['route'] }}">{{ $item['title'] }}</a>
				@endif
			</li>
		@endforeach
	</ul>
</nav>

<nav id="mobile-navigation" class="hidden flex-col absolute top-0 w-full shadow-lg sm:shadow-xl  bg-white z-30" aria-label="Primary Navigation Menu">
	<div class="w-full flex flex-row items-center justify-between p-4 h-16 border-b">
		<header id="navigation-brand">
			<a href="{{ $homeRoute }}" class="font-bold px-4">
				{{ config('hyde.name', 'HydePHP') }}
			</a>
		</header>

		<button class="navigation-toggle-button" title="Close navigation menu" onClick="hideNavigation()">
			<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
		</button>
	</div>

	<ul id="mobile-navigation-links" class="block w-full p-4 overflow-y-auto">
		@foreach ($links as $item)
			<li @class([
					'py-2',
					'list-item',
					'list-item-active' => $item['current']
				])>
				@if($item['current'])
					<a href="{{ $item['route'] }}" aria-current="page" class="text-indigo-500">{{ $item['title'] }}</a>
				@else
					<a href="{{ $item['route'] }}" class="hover:text-indigo-500">{{ $item['title'] }}</a>
				@endif
			</li>
		@endforeach
	</ul>
</nav>


<script>
	const mainNavigation = document.getElementById("main-navigation");
	const mobileNavigation = document.getElementById("mobile-navigation");
	var navigationOpen = false;

	function toggleNavigation() {
		if (navigationOpen) {
			hideNavigation();
		} else {
			showNavigation();
		}
	}

	function showNavigation() {
		mobileNavigation.classList.add("flex");
		mobileNavigation.classList.remove("hidden");

		navigationOpen = true;
	}

	function hideNavigation() {
		mobileNavigation.classList.remove("flex");
		mobileNavigation.classList.add("hidden");

		navigationOpen = false;
	}

</script>
