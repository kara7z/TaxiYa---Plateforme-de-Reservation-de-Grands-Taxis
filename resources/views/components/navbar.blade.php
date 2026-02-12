@php
  $linkBase = "inline-flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold transition
               hover:bg-slate-100 dark:hover:bg-slate-900";
  $linkActive = "bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-white";
@endphp

<header class="sticky top-0 z-50 border-b border-white/40 bg-white/70 backdrop-blur dark:border-slate-800/60 dark:bg-slate-950/60">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">

    {{-- Logo (TEXT ONLY) --}}
    <a href="{{ route('home') }}" class="group flex items-center gap-2">
      <div class="leading-tight">
        <div class="text-lg font-extrabold tracking-tight">
          <span class="bg-gradient-to-r from-indigo-600 to-emerald-500 bg-clip-text text-transparent">
            TaxiYa
          </span>
        </div>
        <div class="text-[11px] text-slate-500 dark:text-slate-400">
          Grands Taxis, version digitale
        </div>
      </div>
    </a>

    {{-- Desktop nav --}}
    <nav class="hidden items-center gap-1 md:flex">
      <a href="{{ route('trips.search') }}"
         class="{{ $linkBase }} {{ request()->routeIs('trips.search') ? $linkActive : '' }}">
        Rechercher
      </a>

      <a href="{{ route('driver.dashboard') }}"
         class="{{ $linkBase }} {{ request()->routeIs('driver.*') ? $linkActive : '' }}">
        Chauffeur
      </a>

      <a href="{{ route('admin.dashboard') }}"
         class="{{ $linkBase }} {{ request()->routeIs('admin.*') ? $linkActive : '' }}">
        Admin
      </a>
    </nav>

    {{-- Right actions --}}
    <div class="flex items-center gap-2">

      {{-- Theme toggle (no extra libs needed) --}}
      <button type="button" id="themeToggle"
              class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white shadow-sm
                     hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800"
              aria-label="Toggle theme">
        <span id="themeIcon" class="text-sm">🌙</span>
      </button>
      @guest
      <div class="hidden items-center gap-2 sm:flex">
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
      </div>
      @endguest
      @auth
      <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          @method('DELETE')

          <button type="submit"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold shadow-sm
                   hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800">
            Se déconnecter
          </button>
        </form>
      @endauth
      {{-- Mobile menu (pure HTML - no Alpine) --}}
      <details class="relative md:hidden">
        <summary
          class="list-none grid h-10 w-10 cursor-pointer place-items-center rounded-xl border border-slate-200 bg-white shadow-sm
                 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800"
          aria-label="Menu">
          ☰
        </summary>

        <div
          class="absolute right-0 mt-3 w-64 overflow-hidden rounded-2xl border border-white/40 bg-white/95 p-2 shadow-lg backdrop-blur
                 dark:border-slate-800/60 dark:bg-slate-950/90">
          <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
             href="{{ route('trips.search') }}">Rechercher</a>
        
          <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
             href="{{ route('driver.dashboard') }}">Espace chauffeur</a>

          <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
             href="{{ route('admin.dashboard') }}">Admin</a>

          <div class="my-2 h-px bg-slate-200 dark:bg-slate-800"></div>
        
      
        
          <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-100 dark:hover:bg-slate-900"
             href="{{ route('login') }}">Se connecter</a>

          <a class="block rounded-xl bg-slate-900 px-3 py-2 font-semibold text-white hover:bg-slate-800
                    dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100"
             href="{{ route('register') }}">Créer un compte</a>
      
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
