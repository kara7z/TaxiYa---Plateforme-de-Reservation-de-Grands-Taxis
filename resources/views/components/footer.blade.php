<footer class="border-t border-white/40 bg-white/70 backdrop-blur dark:border-slate-800/60 dark:bg-slate-950/60">
  <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 lg:px-8 md:grid-cols-3">

    {{-- Brand --}}
    <div>
      <a href="{{ route('home') }}" class="inline-flex items-center">
        <span class="text-lg font-extrabold tracking-tight">
          <span class="bg-gradient-to-r from-indigo-600 to-emerald-500 bg-clip-text text-transparent">
            TaxiYa
          </span>
        </span>
      </a>

      <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
        Prototype (5 jours) — Réservation de places dans les Grands Taxis, horaires clairs, départs plus fluides.
      </p>

      <div class="mt-5 inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold
                  dark:border-slate-800 dark:bg-slate-900">
        <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
        Mobile-first • MVP
      </div>
    </div>

    {{-- Links --}}
    <div class="text-sm">
      <div class="font-semibold">Voyageur</div>
      <div class="mt-3 grid gap-2 text-slate-600 dark:text-slate-400">
        <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('trips.search') }}">Rechercher un trajet</a>
        <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('login') }}">Connexion</a>
        <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('register') }}">Créer un compte</a>
      </div>
    </div>

    <div class="text-sm">
      <div class="font-semibold">Chauffeur & Admin</div>
      <div class="mt-3 grid gap-2 text-slate-600 dark:text-slate-400">
        <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('driver.dashboard') }}">Dashboard chauffeur</a>
        <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('driver.trips.create') }}">Créer un trajet</a>
        <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('admin.dashboard') }}">Admin</a>
      </div>

      <div class="mt-6 text-xs text-slate-500 dark:text-slate-500">
        © {{ date('Y') }} TaxiYa — Tous droits réservés.
      </div>
    </div>

  </div>
</footer>
