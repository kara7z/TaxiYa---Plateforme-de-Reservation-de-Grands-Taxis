@php
  $isActive = fn ($pattern) => request()->routeIs($pattern);

  $pillBase = "inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
               text-slate-600 hover:text-slate-900 hover:bg-slate-100
               dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-900";

  $pillActive = "bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-white";

  $role = auth()->check() ? auth()->user()->role : null;

  $roleBadge = match($role) {
    'admin' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-200',
    'driver' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-200',
    'passenger' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200',
    default => 'bg-slate-100 text-slate-700 dark:bg-slate-900 dark:text-slate-200',
  };
@endphp

<header class="sticky top-0 z-50 border-b border-white/40 bg-white/70 backdrop-blur dark:border-slate-800/60 dark:bg-slate-950/60">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">

    {{-- Brand --}}
    <a href="{{ route('home') }}" class="group flex items-center gap-3">
      <div class="grid h-10 w-10 place-items-center rounded-2xl bg-slate-900 text-white shadow-sm ring-1 ring-black/5
                  dark:bg-white dark:text-slate-900 dark:ring-white/10">
        TY
      </div>

      <div class="leading-tight">
        <div class="text-base font-extrabold tracking-tight">
          <span class="bg-gradient-to-r from-indigo-600 to-emerald-500 bg-clip-text text-transparent">TaxiYa</span>
        </div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400">
          Grands taxis, version digitale
        </div>
      </div>
    </a>

    {{-- Desktop nav --}}
    <nav class="hidden items-center gap-1 md:flex">
      <a href="{{ route('trips.search') }}"
         class="{{ $pillBase }} {{ $isActive('trips.search') ? $pillActive : '' }}">
        Rechercher
      </a>

      @auth
        @if($role === 'passenger')
          <a href="{{ route('booking.index') }}"
             class="{{ $pillBase }} {{ $isActive('booking.*') ? $pillActive : '' }}">
            Mes réservations
          </a>
        @endif

        @if($role === 'driver')
          <a href="{{ route('driver.dashboard') }}"
             class="{{ $pillBase }} {{ $isActive('driver.dashboard') ? $pillActive : '' }}">
            Dashboard
          </a>

          <a href="{{ route('driver.trips.create') }}"
             class="{{ $pillBase }} {{ $isActive('driver.trips.create') ? $pillActive : '' }}">
            Créer un trajet
          </a>
        @endif

        @if($role === 'admin')
          <a href="{{ route('admin.dashboard') }}"
             class="{{ $pillBase }} {{ $isActive('admin.*') ? $pillActive : '' }}">
            Admin
          </a>
        @endif
      @endauth
    </nav>

    <div class="flex items-center gap-2">

      {{-- Theme toggle --}}
      <button type="button" id="themeToggle"
              class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm
                     hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800"
              aria-label="Toggle theme">
        <span id="themeIcon" class="text-sm">🌙</span>
      </button>

      {{-- Desktop: auth / user menu --}}
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
          {{-- User chip dropdown (no JS framework) --}}
          <details class="relative">
            <summary
              class="list-none cursor-pointer inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold shadow-sm
                     hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800">
              <span class="grid h-7 w-7 place-items-center rounded-lg bg-slate-900 text-white text-xs dark:bg-white dark:text-slate-900">
                {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
              </span>
              <span class="max-w-[140px] truncate">{{ auth()->user()->name }}</span>

              <span class="rounded-lg px-2 py-1 text-[11px] font-extrabold {{ $roleBadge }}">
                {{ $role }}
              </span>

              <span class="text-slate-500">▾</span>
            </summary>

            <div class="absolute right-0 mt-3 w-64 overflow-hidden rounded-2xl border border-white/40 bg-white/95 p-2 shadow-lg backdrop-blur
                        dark:border-slate-800/60 dark:bg-slate-950/90">
              <div class="px-3 py-2">
                <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">Connecté en tant que</div>
                <div class="mt-1 text-sm font-extrabold text-slate-900 dark:text-white truncate">
                  {{ auth()->user()->email }}
                </div>
              </div>

              <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>

              {{-- Quick links by role --}}
              @if($role === 'passenger')
                <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
                   href="{{ route('booking.index') }}">
                  Mes réservations
                </a>
              @endif

              @if($role === 'driver')
                <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
                   href="{{ route('driver.dashboard') }}">
                  Dashboard chauffeur
                </a>
                <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
                   href="{{ route('driver.trips.create') }}">
                  Créer un trajet
                </a>
              @endif

              @if($role === 'admin')
                <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
                   href="{{ route('admin.dashboard') }}">
                  Admin
                </a>
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

      {{-- Mobile menu (single place for auth actions) --}}
      <details class="relative md:hidden">
        <summary
          class="list-none grid h-10 w-10 cursor-pointer place-items-center rounded-xl border border-slate-200 bg-white shadow-sm
                 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800"
          aria-label="Menu">
          ☰
        </summary>

        <div class="absolute right-0 mt-3 w-72 overflow-hidden rounded-2xl border border-white/40 bg-white/95 p-2 shadow-lg backdrop-blur
                    dark:border-slate-800/60 dark:bg-slate-950/90">

          @auth
            <div class="px-3 py-2">
              <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">Compte</div>
              <div class="mt-1 flex items-center justify-between gap-2">
                <div class="min-w-0">
                  <div class="truncate text-sm font-extrabold text-slate-900 dark:text-white">{{ auth()->user()->name }}</div>
                  <div class="truncate text-xs text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</div>
                </div>
                <span class="shrink-0 rounded-lg px-2 py-1 text-[11px] font-extrabold {{ $roleBadge }}">
                  {{ $role }}
                </span>
              </div>
            </div>
            <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>
          @endauth

          <div class="px-3 py-2">
            <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">Navigation</div>
          </div>

          <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
             href="{{ route('trips.search') }}">Rechercher</a>

          @auth
            @if($role === 'passenger')
              <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
                 href="{{ route('booking.index') }}">Mes réservations</a>
            @endif

            @if($role === 'driver')
              <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
                 href="{{ route('driver.dashboard') }}">Dashboard</a>
              <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
                 href="{{ route('driver.trips.create') }}">Créer un trajet</a>
            @endif

            @if($role === 'admin')
              <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
                 href="{{ route('admin.dashboard') }}">Admin</a>
            @endif

            <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>

            <form method="POST" action="{{ route('logout') }}" class="block">
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

            <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
               href="{{ route('login') }}">Se connecter</a>

            <a class="block rounded-xl bg-slate-900 px-3 py-2 font-semibold text-white hover:bg-slate-800
                      dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100"
               href="{{ route('register') }}">Créer un compte</a>

            <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
               href="{{ route('driver.register') }}">Devenir chauffeur</a>
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
