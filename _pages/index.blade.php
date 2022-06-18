<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Welcome to HydePHP!</title>

    <style>
        /*! tailwindcss v3.0.23 | MIT License | https://tailwindcss.com*/
        *,:after,:before{box-sizing:border-box;border:0 solid #e5e7eb}:after,:before{--tw-content:""}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji}body{margin:0;line-height:inherit}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b{font-weight:bolder}code{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-size:1em}[type=button],[type=reset],[type=submit]{-webkit-appearance:button;background-color:initial;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}h1,h2,h3,h4,h5,h6,p{margin:0}[role=button]{cursor:pointer}:disabled{cursor:default}[hidden]{display:none}*,:after,:before{--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-scroll-snap-strictness:proximity;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:#3b82f680;--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000}.container{width:100%}@media (min-width:640px){.container{max-width:640px}}@media (min-width:768px){.container{max-width:768px}}@media (min-width:1024px){.container{max-width:1024px}}@media (min-width:1280px){.container{max-width:1280px}}@media (min-width:1536px){.container{max-width:1536px}}.static{position:static}.relative{position:relative}.top-0{top:0}.left-0{left:0}.m-2{margin:.5rem}.my-auto{margin-top:auto;margin-bottom:auto}.mx-auto{margin-left:auto;margin-right:auto}.mx-3{margin-left:.75rem;margin-right:.75rem}.mb-4{margin-bottom:1rem}.mt-2{margin-top:.5rem}.mt-8{margin-top:2rem}.mt-4{margin-top:1rem}.mt-auto{margin-top:auto}.block{display:block}.flex{display:flex}.hidden{display:none}.h-16{height:4rem}.h-screen{height:100vh}.min-h-screen{min-height:100vh}.w-screen{width:100vw}.w-64{width:16rem}.max-w-7xl{max-width:80rem}.max-w-lg{max-width:32rem}.max-w-3xl{max-width:48rem}.flex-col{flex-direction:column}.flex-wrap{flex-wrap:wrap}.justify-center{justify-content:center}.overflow-hidden{overflow:hidden}.overflow-x-hidden{overflow-x:hidden}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255/var(--tw-bg-opacity))}.bg-gradient-to-br{background-image:linear-gradient(to bottom right,var(--tw-gradient-stops))}.bg-clip-text{-webkit-background-clip:text;background-clip:text}.p-4{padding:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.px-4{padding-left:1rem;padding-right:1rem}.py-32{padding-top:8rem;padding-bottom:8rem}.py-2{padding-top:.5rem;padding-bottom:.5rem}.py-16{padding-top:4rem;padding-bottom:4rem}.px-8{padding-left:2rem;padding-right:2rem}.pb-12{padding-bottom:3rem}.text-left{text-align:left}.text-center{text-align:center}.text-5xl{font-size:3rem;line-height:1}.text-4xl{font-size:2.25rem;line-height:2.5rem}.text-sm{font-size:.875rem;line-height:1.25rem}.font-extrabold{font-weight:800}.font-bold{font-weight:700}.uppercase{text-transform:uppercase}.leading-10{line-height:2.5rem}.tracking-tight{letter-spacing:-.025em}.tracking-normal{letter-spacing:0}.text-gray-100{--tw-text-opacity:1;color:rgb(243 244 246/var(--tw-text-opacity))}.text-transparent{color:#0000}.text-gray-200{--tw-text-opacity:1;color:rgb(229 231 235/var(--tw-text-opacity))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255/var(--tw-text-opacity))}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-lg{--tw-shadow:0 10px 15px -3px #0000001a,0 4px 6px -4px #0000001a;--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color),0 4px 6px -4px var(--tw-shadow-color)}.shadow-lg,.shadow-md{box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow)}.shadow-md{--tw-shadow:0 4px 6px -1px #0000001a,0 2px 4px -2px #0000001a;--tw-shadow-colored:0 4px 6px -1px var(--tw-shadow-color),0 2px 4px -2px var(--tw-shadow-color)}.drop-shadow-2xl{--tw-drop-shadow:drop-shadow(0 25px 25px #00000026);filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}@media (min-width:640px){.sm\:mb-0{margin-bottom:0}.sm\:mt-4{margin-top:1rem}.sm\:leading-none{line-height:1}.sm\:shadow-xl{--tw-shadow:0 20px 25px -5px #0000001a,0 8px 10px -6px #0000001a;--tw-shadow-colored:0 20px 25px -5px var(--tw-shadow-color),0 8px 10px -6px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow)}}@media (min-width:768px){.md\:absolute{position:absolute}.md\:left-72{left:18rem}.md\:mt-8{margin-top:2rem}.md\:mt-0{margin-top:0}.md\:inline-block{display:inline-block}.md\:flex{display:flex}.md\:hidden{display:none}.md\:max-w-none{max-width:none}.md\:max-w-2xl{max-width:42rem}.md\:text-center{text-align:center}.md\:text-6xl{font-size:3.75rem;line-height:1}.md\:text-5xl{font-size:3rem;line-height:1}}@media (min-width:1024px){.lg\:text-7xl{font-size:4.5rem;line-height:1}.lg\:text-lg{font-size:1.125rem;line-height:1.75rem}}@media (min-width:1280px){.xl\:left-80{left:20rem}}.sr-only{position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0;}.list-none{list-style-type: none;}
    </style>

    <style>
        /* Gradients by https://uigradients.com/ */
        .app-gradient {
            /* Royal */
            background: #141E30; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left bottom, #243B55, #141E30); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left bottom, #243B55, #141E30); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
        .logo-gradient {
            /* Crimson Tide */
            background-image: linear-gradient(to bottom right, #642B73, #C6426E);
            padding-top: .5rem;
            padding-bottom: 1rem;
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden min-w-screen min-h-screen flex flex-col app-gradient">
    <main class="my-auto px-6 pb-12 antialiased app-gradient-dark">
        <div class="mx-auto max-w-7xl">
            <!-- Main Hero Content -->
            <div class="container max-w-lg px-4 py-32 mx-auto text-left md:max-w-none md:text-center">
                <h1
                    class="text-5xl font-extrabold leading-10 tracking-tight text-left text-gray-100 md:text-center sm:leading-none md:text-6xl lg:text-7xl">
                    <span class="block text-4xl md:text-5xl mb-4 sm:mb-0">You're running on </span><span
                        class="relative mt-2 text-transparent bg-clip-text bg-gradient-to-br logo-gradient md:inline-block drop-shadow-2xl tracking-normal">HydePHP</span>
                </h1>
                <div class="mx-auto mt-8 sm:mt-4 text-gray-200 md:mt-8 md:max-w-2xl md:text-center">
                    <section aria-label="About Hyde">
                        <p class="lg:text-lg">
                            Leap into the future of static HTML blogs and documentation with the tools you already know and love.
                            Made with Tailwind, Laravel, and Coffee.
                        </p>
                    </section>
                    
                    <section aria-label="About this page">
                        <p class="mt-4 mb-4">
                            This is the default homepage stored as index.blade.php, however you can publish any of the built-in views using the following command:
                                                    
                            <!-- Syntax highlighted by torchlight.dev -->
                            <pre style="margin-top: 1.5rem; margin-bottom: 1.5rem;"><code data-theme="material-theme-palenight" data-lang="bash" class="torchlight" style="background-color: #292D3E; padding: 0.5rem 1rem; border-radius: 0.25rem;"><span style="color: #FFCB6B;">php hyde</span> <span style="color: #C3E88D;">publish:homepage</span></code></pre>
                        </p>
                    </section>

                    <div class="mt-4 md:mt-8 text-white">
                        <span class="sr-only">Resources for getting started</span>
                        <ul class="flex flex-wrap justify-center list-none" style="padding: 0;">
                            <li>
                                <a href="https://hydephp.com/docs/master" class="uppercase font-bold text-sm flex text-center m-2 mx-3">
                                    Documentation
                                </a>
                            </li>
                            <li>
                                <a href="https://hydephp.com/docs/master/getting-started" class="uppercase font-bold text-sm flex text-center m-2 mx-3">
                                    Getting Started
                                </a>
                            </li>
                            <li>

                                <a href="https://github.com/hydephp/hyde" class="uppercase font-bold text-sm flex text-center m-2 mx-3">
                                    GitHub Source Code
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Main Hero Content -->
        </div>
    </main>
</body>

</html>