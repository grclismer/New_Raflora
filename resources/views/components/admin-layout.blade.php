@props(['title' => 'Admin Dashboard'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Raflora Enterprises</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="min-h-screen bg-purple-50 flex">
    <aside class="w-64 bg-white shadow-lg flex-shrink-0 flex flex-col">
        <div class="p-6 border-b border-purple-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-purple-700 flex items-center justify-center">
                    <i class="fa-solid fa-crown text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="serif text-lg font-bold text-purple-900">Raflora Admin</h2>
                    <p class="text-xs text-purple-600">Administrator Panel</p>
                </div>
            </div>
        </div>

        <nav class="p-4 space-y-4 flex-1">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 mb-2">Overview</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-purple-100 text-purple-800 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' }}">
                    <i class="fa-solid fa-gauge w-5"></i><span>Dashboard</span>
                </a>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 mb-2">Bookings</p>
                <a href="{{ route('admin.bookings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.bookings*') ? 'bg-purple-100 text-purple-800 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' }}">
                    <i class="fa-solid fa-calendar-days w-5"></i><span>All Bookings</span>
                </a>
                <a href="{{ route('admin.quotations') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.quotations*') ? 'bg-purple-100 text-purple-800 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-5"></i><span>Quotations</span>
                </a>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 mb-2">Operations</p>
                <a href="{{ route('admin.ai-analysis') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.ai-analysis*') ? 'bg-purple-100 text-purple-800 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' }}">
                    <i class="fa-solid fa-brain w-5"></i><span>AI Analysis</span>
                </a>
                <a href="{{ route('admin.quotations') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.quotations*') ? 'bg-purple-100 text-purple-800 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-5"></i><span>Quotations</span>
                </a>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 mb-2">Clients</p>
                <a href="{{ route('admin.client-records') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.client-records*') ? 'bg-purple-100 text-purple-800 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' }}">
                    <i class="fa-solid fa-folder-open w-5"></i><span>Client Records</span>
                </a>
            </div>

            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-purple-500 mb-2">System</p>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.settings*') ? 'bg-purple-100 text-purple-800 font-semibold' : 'text-gray-600 hover:bg-purple-50 hover:text-purple-700' }}">
                    <i class="fa-solid fa-gear w-5"></i><span>Settings</span>
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-purple-100">
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-purple-700 text-white font-semibold shadow hover:bg-purple-800 transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
            <h1 class="serif text-2xl font-bold text-purple-900">{{ $title }}</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="text-sm text-purple-600 hover:text-purple-800 transition">View Site</a>
                <button class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                    <i class="fa-solid fa-bell text-purple-700"></i>
                </button>
            </div>
        </header>

        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
