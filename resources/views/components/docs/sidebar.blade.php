@include('components.docs.header')
<nav id="sidebar-navigation" class="p-4 overflow-y-auto" aria-label="Secondary Navigation Menu">
	<ul>
		@foreach (App\Actions\GeneratesDocumentationSidebar::get($currentPage) as $item)
			<li @class([
					'py-2',
					'list-item',
					'list-item-active' => $item['active']
				])>
				@if($item['active'])
					<span aria-current="true" class="text-indigo-500">{{ $item['title'] }}</span>
				@else
					<a href="{{ $item['slug'] }}.html" class="hover:text-indigo-500">{{ $item['title'] }}</a>
				@endif
			</li>
		@endforeach
	</ul>
</nav>
@include('components.docs.footer')
