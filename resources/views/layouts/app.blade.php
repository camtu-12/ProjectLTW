<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  </head>
  <body class="antialiased bg-gray-50 font-sans">
    <div class="min-h-screen">
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-6">
          <a href="/" class="text-lg font-semibold">My Shop Admin</a>
        </div>
      </header>

      <main class="py-6">
        <div class="max-w-7xl mx-auto px-6">
          @yield('content')
        </div>
      </main>
    </div>
  </body>
</html>
