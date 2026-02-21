<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>jaykod.io</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900" rel="stylesheet" />
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans antialiased bg-[#0a0a0a] text-white">
    <!-- Preloader -->
    <div id="preloader" class="preloader-overlay">
        <div class="preloader-dot"></div>
    </div>
    <style>
        .preloader-overlay {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0a0a;
            opacity: 1;
            transition: opacity .5s cubic-bezier(.4,0,.2,1);
        }
        .preloader-overlay.fade-out {
            opacity: 0;
            pointer-events: none;
        }
        .preloader-dot {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            will-change: transform, opacity, background-color, box-shadow;
            animation: dot-breathe 1.6s cubic-bezier(.4,0,.2,1) infinite;
        }
        @keyframes dot-breathe {
            0% {
                transform: scale(0.15);
                opacity: 0.6;
                background-color: #00ff88;
                box-shadow: 0 0 0 0 rgba(0,255,136,.3);
            }
            30% {
                opacity: 1;
                background-color: #00ff88;
                box-shadow: 0 0 12px 4px rgba(0,255,136,.25);
            }
            60% {
                transform: scale(1);
                opacity: 0.8;
                background-color: #33ffaa;
                box-shadow: 0 0 20px 8px rgba(51,255,170,.2);
            }
            80% {
                transform: scale(1.15);
                opacity: 0.3;
                background-color: #66ffbb;
                box-shadow: 0 0 24px 10px rgba(102,255,187,.15);
            }
            100% {
                transform: scale(1.25);
                opacity: 0;
                background-color: #99ffdd;
                box-shadow: 0 0 0 0 rgba(153,255,221,0);
            }
        }
    </style>
    <script>
        (function(){
            var done = false;
            function hide() {
                if (done) return;
                done = true;
                var el = document.getElementById('preloader');
                if (!el) return;
                el.classList.add('fade-out');
                setTimeout(function(){ el.remove(); }, 550);
            }
            var check = setInterval(function(){
                var app = document.getElementById('app');
                if (app && app.childElementCount > 0) { clearInterval(check); hide(); }
            }, 60);
            setTimeout(function(){ clearInterval(check); hide(); }, 6000);
        })();
    </script>
    @inertia
</body>
</html>
