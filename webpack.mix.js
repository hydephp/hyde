let mix = require('laravel-mix');

// Base assets
mix.postCss('resources/assets/app.css', 'app.css', [
	require('tailwindcss'),
	require('autoprefixer'),
]).setPublicPath('_media')
	.copyDirectory('_media', '_site/media');

// Hyde assets (optional, you can load these (and a base Tailwind) from the CDN if you want)
// NYI