// Using Laravel Mix is optional as the styles you need to get started are already included.
// However, if you add new Tailwind classes, or any customizations, you can use Webpack to
// compile the assets. See https://hydephp.github.io/docs/master/managing-assets.html.

let mix = require('laravel-mix');

mix.js('resources/assets/app.js', 'app.js')
	.ts('resources/assets/hyde.ts', 'app.js')
	.postCss('resources/assets/app.css', 'app.css', [
	require('tailwindcss'),
	require('autoprefixer'),
	]).sass('resources/assets/hyde.scss', 'app.css')
	.setPublicPath('_media')
	.copyDirectory('_media', '_site/media');

	mix.webpackConfig({
		output: {                                                                                                                                                                          
			library: {                                                                                                                                                                       
			  type: "window",                                                                                                                                                                
			},                                                                                                                                                                               
		  },
	  })