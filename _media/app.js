// Handle the main navigation menu

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

// Handle the documentation page sidebar

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