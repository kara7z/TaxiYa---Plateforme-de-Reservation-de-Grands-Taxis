<footer class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
  <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

    <div class="grid gap-10 md:grid-cols-3">
      <div>
        <div class="text-lg font-extrabold tracking-tight">
          <span class="bg-gradient-to-r from-indigo-600 to-emerald-500 bg-clip-text text-transparent">TaxiYa</span>
        </div>
        <p class="mt-2 max-w-sm text-sm text-slate-600 dark:text-slate-400">
          Plateforme simple pour chercher, réserver et gérer les trajets en grands taxis.
        </p>

        <div class="mt-4 inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-600
                    dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
          <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
          Maroc
        </div>
      </div>

      <div>
        <div class="text-sm font-semibold text-slate-900 dark:text-white">Navigation</div>
        <div class="mt-3 grid gap-2 text-sm text-slate-600 dark:text-slate-400">
          <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('home') }}">Accueil</a>
          <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('trips.search') }}">Rechercher</a>

          @auth
            @if(auth()->user()->role === 'passenger')
              <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('booking.index') }}">Mes réservations</a>
            @endif

            @if(auth()->user()->role === 'driver')
              <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('driver.dashboard') }}">Dashboard chauffeur</a>
              <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('driver.trips.create') }}">Créer un trajet</a>
            @endif

            @if(auth()->user()->role === 'admin')
              <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('admin.dashboard') }}">Admin</a>
            @endif
          @endauth
        </div>
      </div>

      <div>
        <div class="text-sm font-semibold text-slate-900 dark:text-white">Compte</div>
        <div class="mt-3 grid gap-2 text-sm text-slate-600 dark:text-slate-400">
          @guest
            <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('login') }}">Se connecter</a>
            <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('register') }}">Créer un compte</a>
            <a class="hover:text-slate-900 dark:hover:text-white" href="{{ route('driver.register') }}">Devenir chauffeur</a>
          @endguest

          @auth
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-left hover:text-slate-900 dark:hover:text-white">
                Se déconnecter
              </button>
            </form>
          @endauth
        </div>
      </div>
    </div>

    <div class="mt-10 flex flex-col gap-3 border-t border-slate-200 pt-6 text-sm text-slate-500 dark:border-slate-800 dark:text-slate-400 sm:flex-row sm:items-center sm:justify-between">
      <div>© {{ date('Y') }} TaxiYa. Tous droits réservés.</div>
      <div class="flex gap-4">
        <span>Grands taxis</span>
        <span class="opacity-50">•</span>
        <span>Réservation</span>
      </div>
    </div>

  </div>
</footer>
