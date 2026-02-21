<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
        ]);
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
            'track' => \App\Http\Middleware\TrackPageView::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function ($response, $exception, Request $request) {
            // Only render Inertia error pages for non-API, non-debug web requests
            if (! $exception instanceof HttpExceptionInterface) {
                // For non-HTTP exceptions in production, render a 500 page
                if (! app()->hasDebugModeEnabled() && in_array($request->header('X-Inertia'), ['true', true], true)) {
                    return Inertia::render('Errors/ErrorPage', ['status' => 500])
                        ->toResponse($request)
                        ->setStatusCode(500);
                }

                return $response;
            }

            $status = $response->getStatusCode();
            $errorStatuses = [403, 404, 419, 429, 500, 503];

            if (in_array($status, $errorStatuses) && ! $request->expectsJson()) {
                return Inertia::render('Errors/ErrorPage', ['status' => $status])
                    ->toResponse($request)
                    ->setStatusCode($status);
            }

            return $response;
        });
    })->create();
