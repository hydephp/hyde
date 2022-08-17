<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Hyde\Framework\Application(
    dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    LaravelZero\Framework\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    Illuminate\Foundation\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Set Important Hyde Configurations
|--------------------------------------------------------------------------
|
| Now, we create a new instance of the HydeKernel, which encapsulates
| our Hyde project and provides helpful methods for interacting with it.
| Then, we bind the kernel into the application service container.
|
*/

$hyde = new Hyde\Framework\HydeKernel(
    dirname(__DIR__)
);

$app->singleton(
    Hyde\Framework\HydeKernel::class, function () {
        return Hyde\Framework\HydeKernel::getInstance();
    }
);

Hyde\Framework\HydeKernel::setInstance($hyde);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
