<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Metrics')</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">
<div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <nav class="mb-4 flex justify-end">
        <select id="languageSelect" class="px-4 py-2 rounded-lg bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
            <option value="es" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>Español</option>
        </select>
    </nav>
    <h1 class="text-3xl font-semibold text-center mb-6">@yield('header', 'Metrics')</h1>
    @yield('content')
</div>
@vite('resources/js/app.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('languageSelect').addEventListener('change', function() {
        const selectedLanguage = this.value;
        window.location.href = `/language/${selectedLanguage}`;
    });
</script>
</body>
</html>
