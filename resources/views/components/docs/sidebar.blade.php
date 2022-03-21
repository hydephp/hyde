@include('components.docs.sidebar-header')
<nav id="sidebar-navigation" class="p-4 overflow-y-auto" aria-label="Secondary Navigation Menu">
	<ul>
		@foreach (Hyde\Framework\Actions\GeneratesDocumentationSidebar::get($currentPage) as $item)
			<li @class([
					'py-2',
					'list-item',
					'list-item-active' => $item['active']
				])>
				@if($item['active'])
					<a href="{{ $item['slug'] }}.html" aria-current="true" class="text-indigo-500">{{ $item['title'] }}</a>
				@else
					<a href="{{ $item['slug'] }}.html" class="hover:text-indigo-500">{{ $item['title'] }}</a>
				@endif
			</li>
		@endforeach
	</ul>
</nav>
@include('components.docs.sidebar-footer')
