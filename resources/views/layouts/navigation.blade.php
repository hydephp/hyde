<nav id="main-navigation" aria-label="Primary Navigation Menu">
	<ul>
		@foreach (App\Actions\GeneratesNavigationMenu::getNavigationLinks($currentPage) as $item)
			<li>
				@if($item['current'])
					<span aria-current="page">{{ $item['title'] }}</span>
				@else
					<a href="{{ $item['route'] }}">{{ $item['title'] }}</a>
				@endif
			</li>
		@endforeach
	</ul>
</nav>