{{-- The Markdown Page Layout --}}
@extends('layouts.app')
@section('content')

<main class="mx-auto max-w-7xl py-16 px-8">
	<article @class(['mx-auto prose max-w-5xl', 'torchlight-enabled' => App\Core\Hyde::hasTorchlight()])>
		{!! $markdown !!}
	</article>
</main>

@endsection
