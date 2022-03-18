<nav id="main-navigation" aria-label="Primary Navigation Menu">
	<ul>
		@foreach (App\Actions\GeneratesNavigationMenu::getNavigationLinks($currentPage) as $item)
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