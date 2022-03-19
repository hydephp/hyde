{{-- The Documentation Page Layout based on Laradocgen --}}
@extends('layouts.app')
@section('content')
@php($withoutNavigation = true)
<nav id="documentation-navigation" class="md:hidden fixed top-0 w-screen h-16 p-4 shadow-lg sm:shadow-xl overflow-hidden bg-white z-30">
	@include('components.docs.navigation')
</nav>
<aside id="documentation-sidebar" class="w-64 h-screen hidden md:flex flex-col fixed top-0 left-0 shadow-md overflow-hidden bg-white z-20">
	@include('components.docs.sidebar')
</aside>
<main id="documentation-content" class="mx-auto max-w-7xl py-16 px-8 mt-8 md:mt-0 md:absolute md:left-72 xl:left-80">
	@include('components.docs.content')
</main>

<script>
	var sidebarOpen = screen.width >= 768;

	const sidebar = document.getElementById("documentation-sidebar");
	const main = document.getElementById("documentation-content");
	const backdrop = document.getElementById("sidebar-backdrop");

	const toggleButtons = document.querySelectorAll(".sidebar-button-wrapper");

	function toggleSidebar() {
		if (sidebarOpen) {
			hideSidebar();
		} else {
			showSidebar();
		}
	}

	function showSidebar() {
		sidebar.classList.remove("hidden");
		sidebar.classList.add("flex");
		backdrop.classList.remove("hidden");
		document.getElementById("app").style.overflow = "hidden";

		toggleButtons.forEach((button) => {
			button.classList.remove("open");
			button.classList.add("closed");
		});

		sidebarOpen = true;
	}

	function hideSidebar() {
		sidebar.classList.add("hidden");
		sidebar.classList.remove("flex");
		backdrop.classList.add("hidden");
		document.getElementById("app").style.overflow = null;

		toggleButtons.forEach((button) => {
			button.classList.add("open");
			button.classList.remove("closed");
		});

		sidebarOpen = false;
	}

</script>
<div id="sidebar-backdrop" class="hidden" title="Click to close sidebar" onClick="hideSidebar()"></div>
@endsection
