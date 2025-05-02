<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-[#1b1b18] flex flex-col min-h-screen">
        <header class="w-full max-w-4xl mx-auto px-4 py-6 flex justify-between items-center">
            <div class="text-xl font-bold tracking-tight">{{ config('app.name', 'Laravel') }}</div>
            <nav class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="px-5 py-1.5 border border-[#19140035] rounded-sm text-sm font-semibold hover:border-black transition">Log in</a>
                <a href="{{ route('register') }}" class="px-5 py-1.5 border border-[#19140035] rounded-sm text-sm font-semibold bg-[#f7f7f7] hover:border-black transition">Register</a>
            </nav>
        </header>
        <main class="flex-1 flex flex-col items-center justify-center px-4">
            <!-- Hero Section -->
            <section class="w-full max-w-2xl text-center py-12">
                <h1 class="text-3xl md:text-5xl font-extrabold mb-4">Seamless User Onboarding & Admin Review</h1>
                <p class="text-lg md:text-xl text-[#706f6c] mb-8">Secure, multi-step onboarding with document uploads, admin review, notifications, and audit logging.</p>
                <div class="flex justify-center gap-4 mb-8">
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-[#1b1b18] text-white rounded-md text-base font-semibold hover:bg-black transition">Get Started</a>
                    <a href="{{ route('login') }}" class="px-6 py-2 border border-[#19140035] rounded-md text-base font-semibold hover:border-black transition">Log In</a>
                </div>
            </section>
            <!-- Features Section (Text Only) -->
            <section class="w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
                <div class="bg-[#fafafa] rounded-lg p-5 text-center shadow-sm">
                    <h3 class="font-semibold text-lg mb-1">Multi-step Onboarding</h3>
                    <p class="text-sm text-[#706f6c]">Step-by-step registration for a smooth user experience.</p>
                </div>
                <div class="bg-[#fafafa] rounded-lg p-5 text-center shadow-sm">
                    <h3 class="font-semibold text-lg mb-1">Secure Document Uploads</h3>
                    <p class="text-sm text-[#706f6c]">Upload and manage sensitive documents securely.</p>
                </div>
                <div class="bg-[#fafafa] rounded-lg p-5 text-center shadow-sm">
                    <h3 class="font-semibold text-lg mb-1">Admin Review & RBAC</h3>
                    <p class="text-sm text-[#706f6c]">Admins review, approve, or reject users with role-based access.</p>
                </div>
                <div class="bg-[#fafafa] rounded-lg p-5 text-center shadow-sm">
                    <h3 class="font-semibold text-lg mb-1">Notifications & Audit Logs</h3>
                    <p class="text-sm text-[#706f6c]">Automated notifications and comprehensive audit logging.</p>
                </div>
            </section>
            <!-- How it Works Section -->
            <section class="w-full max-w-2xl mb-16">
                <h2 class="text-2xl font-bold mb-6 text-center">How it Works</h2>
                <div class="flex flex-col md:flex-row justify-center items-center gap-8">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-[#f0f0f0] text-[#1b1b18] font-bold mb-2">1</div>
                        <div class="font-semibold mb-1">Register</div>
                        <div class="text-xs text-[#706f6c] text-center">Create your account and start onboarding.</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-[#f0f0f0] text-[#1b1b18] font-bold mb-2">2</div>
                        <div class="font-semibold mb-1">Upload Documents</div>
                        <div class="text-xs text-[#706f6c] text-center">Securely upload your required identification documents.</div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-[#f0f0f0] text-[#1b1b18] font-bold mb-2">3</div>
                        <div class="font-semibold mb-1">Get Approved</div>
                        <div class="text-xs text-[#706f6c] text-center">Wait for admin review and receive notifications on your status.</div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="w-full max-w-4xl mx-auto px-4 py-6 text-center text-xs text-[#706f6c] border-t border-[#e3e3e0]">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
        </footer>
    </body>
</html>
