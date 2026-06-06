<div class="relative inline-block">
    <button id="avatarToggle" class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-md border-2 border-purple-700 overflow-hidden hover:shadow-lg transition">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=8b5cf6&color=fff" alt="Profile" class="w-full h-full object-cover">
    </button>

    <div id="avatarDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
        <div class="py-1">
            <a href="{{ route('bookings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-calendar-days mr-2"></i>My Bookings
            </a>
            <a href="{{ route('account-settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition">
                <i class="fa-solid fa-user-gear mr-2"></i>Account Settings
            </a>
            <hr class="my-1">
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                    <i class="fa-solid fa-sign-out-alt mr-2"></i>Log Out
                </button>
            </form>
        </div>
    </div>

    <script>
        (function(){
            const toggle = document.getElementById('avatarToggle');
            const menu = document.getElementById('avatarDropdown');
            if (!toggle || !menu) return;
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!e.target.closest('#avatarDropdown') && !e.target.closest('#avatarToggle')) {
                    menu.classList.add('hidden');
                }
            });
        })();
    </script>
</div>
