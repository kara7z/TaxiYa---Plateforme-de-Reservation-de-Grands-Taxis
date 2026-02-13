@php
  $role = auth()->check() ? auth()->user()->role : null;

  $roleBadge = match($role) {
    'admin' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-200',
    'driver' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-200',
    'passenger' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200',
    default => 'bg-slate-100 text-slate-700 dark:bg-slate-900 dark:text-slate-200',
  };

  $ddLink = "block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900";
@endphp

<header class="sticky top-0 z-50 border-b border-white/40 bg-white/70 backdrop-blur dark:border-slate-800/60 dark:bg-slate-950/60">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">

    {{-- Brand --}}
    <a href="{{ route('home') }}" class="group flex items-center">
      <div class="leading-tight">
        <div class="text-lg font-extrabold tracking-tight">
          <span class="bg-gradient-to-r from-indigo-600 to-emerald-500 bg-clip-text text-transparent">
            TaxiYa
          </span>
        </div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400">
          Grands taxis, version digitale
        </div>
      </div>
    </a>

    {{-- Desktop nav --}}
    <nav class="hidden items-center gap-1 md:flex">
      <a href="{{ route('trips.search') }}"
         class="inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
                text-slate-600 hover:text-slate-900 hover:bg-slate-100
                dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-900
                {{ request()->routeIs('trips.search') ? 'bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-white' : '' }}">
        Rechercher
      </a>
    </nav>

    <div class="flex items-center gap-2">

      {{-- Theme --}}
      <button type="button" id="themeToggle"
              class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm
                     hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800"
              aria-label="Toggle theme">
        <span id="themeIcon" class="text-sm">🌙</span>
      </button>

      {{-- Desktop: guest buttons OR dropdown for auth --}}
      <div class="hidden items-center gap-2 sm:flex">
        @guest
          <a href="{{ route('login') }}"
             class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold shadow-sm
                    hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800">
            Se connecter
          </a>

          <a href="{{ route('register') }}"
             class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm
                    hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">
            Créer un compte
          </a>
        @endguest

        @auth
          {{-- One dropdown: links + logout --}}
          <details class="relative">
            <summary
              class="list-none cursor-pointer inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm
                     hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800">
              <span class="max-w-[180px] truncate">{{ auth()->user()->name }}</span>

              <span class="rounded-lg px-2 py-1 text-[11px] font-extrabold {{ $roleBadge }}">
                {{ $role }}
              </span>

              <span class="text-slate-500">▾</span>
            </summary>

            <div class="absolute right-0 mt-3 w-64 overflow-hidden rounded-2xl border border-white/40 bg-white/95 p-2 shadow-lg backdrop-blur
                        dark:border-slate-800/60 dark:bg-slate-950/90">

              <div class="px-3 py-2">
                <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">Compte</div>
                <div class="mt-1 text-sm font-extrabold text-slate-900 dark:text-white truncate">
                  {{ auth()->user()->email }}
                </div>
              </div>

              <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>

              {{-- Role-based links inside dropdown --}}
              @if($role === 'passenger')
                <a class="{{ $ddLink }}" href="{{ route('booking.index') }}">Mes réservations</a>
              @endif

              @if($role === 'driver')
                <a class="{{ $ddLink }}" href="{{ route('driver.dashboard') }}">Dashboard chauffeur</a>
                <a class="{{ $ddLink }}" href="{{ route('driver.trips.create') }}">Créer un trajet</a>
              @endif

              @if($role === 'admin')
                <a class="{{ $ddLink }}" href="{{ route('admin.dashboard') }}">Admin dashboard</a>
              @endif

              <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full text-left rounded-xl px-3 py-2 font-semibold text-rose-700 hover:bg-rose-50
                               dark:text-rose-200 dark:hover:bg-rose-950/40">
                  Se déconnecter
                </button>
              </form>
            </div>
          </details>
        @endauth
      </div>

      {{-- Mobile menu --}}
      <details class="relative sm:hidden">
        <summary
          class="list-none grid h-10 w-10 cursor-pointer place-items-center rounded-xl border border-slate-200 bg-white shadow-sm
                 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800"
          aria-label="Menu">
          ☰
        </summary>

        <div class="absolute right-0 mt-3 w-72 overflow-hidden rounded-2xl border border-white/40 bg-white/95 p-2 shadow-lg backdrop-blur
                    dark:border-slate-800/60 dark:bg-slate-950/90">

          <div class="px-3 py-2">
            <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">Navigation</div>
          </div>

          <a class="{{ $ddLink }}" href="{{ route('trips.search') }}">Rechercher</a>

          @auth
            <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>

            @if($role === 'passenger')
              <a class="{{ $ddLink }}" href="{{ route('booking.index') }}">Mes réservations</a>
            @endif

            @if($role === 'driver')
              <a class="{{ $ddLink }}" href="{{ route('driver.dashboard') }}">Dashboard chauffeur</a>
              <a class="{{ $ddLink }}" href="{{ route('driver.trips.create') }}">Créer un trajet</a>
            @endif

            @if($role === 'admin')
              <a class="{{ $ddLink }}" href="{{ route('admin.dashboard') }}">Admin dashboard</a>
            @endif

            <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>

            <form method="POST" action="{{ route('logout') }}">
              @csrf
              @method('DELETE')
              <button type="submit"
                      class="w-full text-left rounded-xl px-3 py-2 font-semibold text-rose-700 hover:bg-rose-50
                             dark:text-rose-200 dark:hover:bg-rose-950/40">
                Se déconnecter
              </button>
            </form>
          @else
            <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>

            <a class="{{ $ddLink }}" href="{{ route('login') }}">Se connecter</a>

            <a class="block rounded-xl bg-slate-900 px-3 py-2 font-semibold text-white hover:bg-slate-800
                      dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100"
               href="{{ route('register') }}">Créer un compte</a>

            <a class="{{ $ddLink }}" href="{{ route('driver.register') }}">Devenir chauffeur</a>
          @endauth
        </div>
      </details>

    </div>
  </div>
</header>

<script>
  (function () {
    const root = document.documentElement;
    const btn = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');

    const apply = (mode) => {
      const isDark = mode === 'dark';
      root.classList.toggle('dark', isDark);
      if (icon) icon.textContent = isDark ? '☀️' : '🌙';
      localStorage.setItem('taxiya_theme', mode);
    };

    const saved = localStorage.getItem('taxiya_theme');
    if (saved) apply(saved);
    else {
      const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
      apply(prefersDark ? 'dark' : 'light');
    }

    btn?.addEventListener('click', () => {
      const isDark = root.classList.contains('dark');
      apply(isDark ? 'light' : 'dark');
    });
  })();
</script>
