<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /**
     * Bot patterns to exclude from tracking.
     */
    protected array $botPatterns = [
        'bot', 'crawl', 'spider', 'slurp', 'mediapartners',
        'facebookexternalhit', 'linkedinbot', 'twitterbot',
        'whatsapp', 'telegrambot', 'pingdom', 'uptimerobot',
        'googlebot', 'bingbot', 'yandexbot', 'baiduspider',
        'lighthouse', 'pagespeed', 'gtmetrix', 'semrush',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests that are actual page visits
        if (
            $request->isMethod('GET') &&
            !$request->ajax() &&
            !$request->wantsJson() &&
            $response->getStatusCode() === 200 &&
            !$this->isBot($request->userAgent() ?? '')
        ) {
            $this->recordView($request);
        }

        return $response;
    }

    protected function isBot(string $userAgent): bool
    {
        $ua = strtolower($userAgent);
        foreach ($this->botPatterns as $pattern) {
            if (str_contains($ua, $pattern)) {
                return true;
            }
        }
        return false;
    }

    protected function recordView(Request $request): void
    {
        try {
            PageView::create([
                'path' => $request->path() === '/' ? '/' : '/' . ltrim($request->path(), '/'),
                'page_name' => $this->getPageName($request->path()),
                'ip_address' => $request->ip(),
                'user_agent' => mb_substr($request->userAgent() ?? '', 0, 500),
                'referrer' => $request->header('referer') ? mb_substr($request->header('referer'), 0, 500) : null,
                'device_type' => $this->detectDeviceType($request->userAgent() ?? ''),
                'browser' => $this->detectBrowser($request->userAgent() ?? ''),
            ]);
        } catch (\Throwable $e) {
            // Silently fail — analytics should never break the site
            report($e);
        }
    }

    protected function getPageName(string $path): string
    {
        $path = trim($path, '/');

        $pageNames = [
            '' => 'Home',
            'about' => 'About',
            'experience' => 'Experience',
            'projects' => 'Projects',
            'contact' => 'Contact',
            'resume/create' => 'Resume Builder',
        ];

        // Exact match
        if (isset($pageNames[$path])) {
            return $pageNames[$path];
        }

        // Prefix match for resume/xxx
        if (str_starts_with($path, 'resume/')) {
            return 'Resume View';
        }

        return ucfirst($path);
    }

    protected function detectDeviceType(string $userAgent): string
    {
        $ua = strtolower($userAgent);

        // Check tablet first (some tablets also match mobile patterns)
        if (preg_match('/tablet|ipad|playbook|silk/i', $ua)) {
            return 'tablet';
        }

        // Mobile devices
        if (preg_match('/mobile|android|iphone|ipod|opera mini|iemobile|wpdesktop|blackberry|windows phone/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }

    protected function detectBrowser(string $userAgent): string
    {
        $ua = $userAgent;

        if (preg_match('/Edg\//i', $ua)) return 'Edge';
        if (preg_match('/OPR\//i', $ua) || preg_match('/Opera/i', $ua)) return 'Opera';
        if (preg_match('/Chrome\//i', $ua) && !preg_match('/Chromium/i', $ua)) return 'Chrome';
        if (preg_match('/Firefox\//i', $ua)) return 'Firefox';
        if (preg_match('/Safari\//i', $ua) && !preg_match('/Chrome/i', $ua)) return 'Safari';
        if (preg_match('/MSIE|Trident/i', $ua)) return 'IE';

        return 'Other';
    }
}
