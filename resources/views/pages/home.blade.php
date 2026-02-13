@extends('layouts.app')
@section('title', 'TaxiYa — Accueil')

@section('content')
<section class="relative overflow-hidden">
  <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid items-center gap-10 lg:grid-cols-2">

      <div>
        <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
          <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
          Réservation rapide • Prix clairs • Chauffeurs vérifiés
        </div>

        <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-5xl">
          Réserve ton grand taxi <span class="text-brand-600">en quelques clics</span>.
        </h1>

        <p class="mt-4 text-base text-slate-600 dark:text-slate-400">
          Cherche un trajet, réserve ta place, et reçois la confirmation. Simple et efficace.
        </p>

        <div class="mt-6 flex flex-wrap gap-3">
          <a href="{{ route('trips.search') }}"
             class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-800
                    dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">
            Rechercher un trajet
          </a>

          @guest
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-50
                      dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
              Créer un compte
            </a>
          @endguest

          @auth
            @if(auth()->user()->role === 'driver')
              <a href="{{ route('driver.trips.create') }}"
                 class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-50
                        dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                Publier un trajet
              </a>
            @endif
          @endauth
        </div>

        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
          <div class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
            <div class="text-lg font-extrabold text-slate-900 dark:text-white">24/7</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">Disponibilité</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
            <div class="text-lg font-extrabold text-slate-900 dark:text-white">+Villes</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">Trajets</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900">
            <div class="text-lg font-extrabold text-slate-900 dark:text-white">Sécurisé</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">Comptes</div>
          </div>
        </div>
      </div>

      <div class="relative">
        <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-tr from-indigo-500/20 to-emerald-500/20 blur-2xl"></div>
        <div class="relative rounded-[2.5rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
          <div class="text-sm font-semibold text-slate-900 dark:text-white">Démarrer vite</div>
          <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            Utilise la recherche pour voir les trajets disponibles.
          </p>

          <div class="mt-5 grid gap-3">
            <a href="{{ route('trips.search') }}"
               class="inline-flex items-center justify-center rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-500">
              Ouvrir la recherche
            </a>

            @guest
              <a href="{{ route('login') }}"
                 class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-50
                        dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                Se connecter
              </a>
            @endguest
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
