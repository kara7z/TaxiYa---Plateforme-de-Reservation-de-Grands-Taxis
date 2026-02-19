@extends('layouts.app')
@section('title', 'TaxiYa — Accueil')

@section('content')
@php
  $role = auth()->check() ? auth()->user()->role : null;
@endphp

{{-- HERO --}}
<section class="relative overflow-hidden">
  <div class="pointer-events-none absolute inset-0">
    <div class="absolute -top-24 left-1/2 h-[520px] w-[820px] -translate-x-1/2 rounded-full bg-gradient-to-tr from-indigo-500/20 via-emerald-500/10 to-sky-500/20 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 h-56 w-56 rounded-full bg-emerald-500/10 blur-2xl"></div>
    <div class="absolute bottom-10 left-0 h-56 w-56 rounded-full bg-indigo-500/10 blur-2xl"></div>
  </div>

  <div class="mx-auto max-w-7xl px-4 pt-10 pb-12 sm:px-6 lg:px-8 lg:pt-14 lg:pb-16">
    <div class="grid items-center gap-10 lg:grid-cols-2">

      {{-- Left --}}
      <div>
        <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/80 px-3 py-1 text-xs font-semibold text-slate-700 shadow-sm backdrop-blur
                    dark:border-slate-800 dark:bg-slate-900/60 dark:text-slate-200">
          <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
          Réservation rapide • Prix clairs • Chauffeurs vérifiés
        </div>

        <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-5xl">
          Réserve ton grand taxi
          <span class="bg-gradient-to-r from-indigo-600 to-emerald-500 bg-clip-text text-transparent">en quelques clics</span>.
        </h1>

        <p class="mt-4 max-w-xl text-base text-slate-600 dark:text-slate-400">
          Cherche un trajet, réserve ta place et reçois la confirmation.
          Une expérience simple, propre et efficace.
        </p>

        <div class="mt-6 flex flex-wrap gap-3">
          <a href="{{ route('trips.search') }}"
             class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm
                    hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">
            Rechercher un trajet
          </a>

          @guest
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm
                      hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
              Créer un compte
            </a>

            <a href="{{ route('driver.register') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm
                      hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
              Devenir chauffeur
            </a>
          @endguest

          @auth
            @if($role === 'driver')
              <a href="{{ route('driver.trips.create') }}"
                 class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm
                        hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                Publier un trajet
              </a>
            @endif

            @if($role === 'passenger')
              <a href="{{ route('booking.index') }}"
                 class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm
                        hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                Mes réservations
              </a>
            @endif

            @if($role === 'admin')
              <a href="{{ route('admin.dashboard') }}"
                 class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm
                        hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                Admin
              </a>
            @endif
          @endauth
        </div>

        {{-- Trust stats --}}
        <div class="mt-8 grid grid-cols-3 gap-3 sm:gap-4">
          <div class="rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm backdrop-blur dark:border-slate-800 dark:bg-slate-900/60">
            <div class="text-lg font-extrabold text-slate-900 dark:text-white">24/7</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">Disponible</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm backdrop-blur dark:border-slate-800 dark:bg-slate-900/60">
            <div class="text-lg font-extrabold text-slate-900 dark:text-white">+Villes</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">Trajets</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm backdrop-blur dark:border-slate-800 dark:bg-slate-900/60">
            <div class="text-lg font-extrabold text-slate-900 dark:text-white">Sécurisé</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">Comptes</div>
          </div>
        </div>
      </div>

      {{-- Right card (Quick start) --}}
      <div class="relative">
        <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-tr from-indigo-500/15 to-emerald-500/15 blur-2xl"></div>

        <div class="relative overflow-hidden rounded-[2.5rem] border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
          <div class="flex items-start justify-between gap-3">
            <div>
              <div class="text-sm font-semibold text-slate-900 dark:text-white">Démarrer vite</div>
              <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                Ouvre la recherche et vois les trajets disponibles.
              </p>
            </div>
            <span class="rounded-xl border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-extrabold text-slate-700
                         dark:border-slate-800 dark:bg-slate-950/40 dark:text-slate-200">
              MVP
            </span>
          </div>

          <div class="mt-5 grid gap-3">
            <a href="{{ route('trips.search') }}"
               class="inline-flex items-center justify-center rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-500">
              Ouvrir la recherche
            </a>

            @auth
              @if($role === 'driver')
                <a href="{{ route('driver.trips.create') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-50
                          dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                  Créer un trajet
                </a>
              @endif

              @if($role === 'passenger')
                <a href="{{ route('booking.index') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-50
                          dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                  Mes réservations
                </a>
              @endif
            @endauth

            @guest
              <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/30">
                <div class="font-semibold text-slate-900 dark:text-white">Nouveau sur TaxiYa ?</div>
                <p class="mt-1 text-slate-600 dark:text-slate-400">
                  Crée un compte pour réserver plus vite.
                </p>
                <div class="mt-3 flex flex-wrap gap-2">
                  <a href="{{ route('register') }}"
                     class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800
                            dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">
                    Créer un compte
                  </a>
                  <a href="{{ route('driver.register') }}"
                     class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-50
                            dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
                    Devenir chauffeur
                  </a>
                </div>
              </div>
            @endguest
          </div>

          <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/30">
            <div class="font-semibold text-slate-900 dark:text-white">Conseil</div>
            <p class="mt-1 text-slate-600 dark:text-slate-400">
              Pour de meilleurs résultats, choisis une date proche et une ville de départ populaire.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- HOW IT WORKS --}}
<section class="border-t border-slate-200/60 dark:border-slate-800/60">
  <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="max-w-2xl">
      <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
        Comment ça marche
      </h2>
      <p class="mt-2 text-slate-600 dark:text-slate-400">
        Une expérience fluide pour les voyageurs, et simple pour les chauffeurs.
      </p>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="text-xs font-extrabold text-brand-600">Étape 1</div>
        <div class="mt-2 text-lg font-extrabold text-slate-900 dark:text-white">Chercher</div>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
          Choisis départ, arrivée et date. On te montre les trajets disponibles.
        </p>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="text-xs font-extrabold text-brand-600">Étape 2</div>
        <div class="mt-2 text-lg font-extrabold text-slate-900 dark:text-white">Réserver</div>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
          Réserve ta place et reçois la confirmation après validation.
        </p>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="text-xs font-extrabold text-brand-600">Étape 3</div>
        <div class="mt-2 text-lg font-extrabold text-slate-900 dark:text-white">Voyager</div>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
          Tu sais où, quand et combien. Une expérience claire dès le départ.
        </p>
      </div>
    </div>
  </div>
</section>

{{-- FEATURES --}}
<section class="bg-slate-50/60 dark:bg-slate-950/20">
  <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="flex items-end justify-between gap-6">
      <div class="max-w-2xl">
        <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
          Pourquoi TaxiYa ?
        </h2>
        <p class="mt-2 text-slate-600 dark:text-slate-400">
          Un design propre, des prix lisibles et une logique simple pour ton MVP.
        </p>
      </div>
      <div class="hidden sm:block">
        <a href="{{ route('trips.search') }}"
           class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-900 shadow-sm
                  hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
          Voir les trajets
        </a>
      </div>
    </div>

    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="text-lg font-extrabold text-slate-900 dark:text-white">Prix clairs</div>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
          Prix/place affiché, pas de surprise.
        </p>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="text-lg font-extrabold text-slate-900 dark:text-white">Comptes par rôle</div>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
          Voyageur, Chauffeur, Admin — chacun son espace.
        </p>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="text-lg font-extrabold text-slate-900 dark:text-white">Expérience mobile</div>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
          Tout est pensé mobile-first pour un usage rapide.
        </p>
      </div>
    </div>
  </div>
</section>

{{-- FAQ --}}
<section class="border-t border-slate-200/60 dark:border-slate-800/60">
  <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="max-w-2xl">
      <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
        Questions fréquentes
      </h2>
      <p class="mt-2 text-slate-600 dark:text-slate-400">
        Quelques réponses rapides pour ton MVP.
      </p>
    </div>

    <div class="mt-8 grid gap-4 lg:grid-cols-2">
      <details class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm open:shadow-md dark:border-slate-800 dark:bg-slate-900">
        <summary class="cursor-pointer list-none font-extrabold text-slate-900 dark:text-white">
          Est-ce que je peux réserver sans compte ?
        </summary>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
          Tu peux chercher librement, mais pour réserver proprement on conseille un compte (plus simple pour “Mes réservations”).
        </p>
      </details>

      <details class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm open:shadow-md dark:border-slate-800 dark:bg-slate-900">
        <summary class="cursor-pointer list-none font-extrabold text-slate-900 dark:text-white">
          Comment publier un trajet ?
        </summary>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
          Crée un compte chauffeur, puis “Créer un trajet” apparaît dans ton menu.
        </p>
      </details>

      <details class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm open:shadow-md dark:border-slate-800 dark:bg-slate-900">
        <summary class="cursor-pointer list-none font-extrabold text-slate-900 dark:text-white">
          Les prix sont-ils fixes ?
        </summary>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
          Pour le MVP, tu peux garder des règles simples (prix/place par route) puis améliorer après.
        </p>
      </details>

      <details class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm open:shadow-md dark:border-slate-800 dark:bg-slate-900">
        <summary class="cursor-pointer list-none font-extrabold text-slate-900 dark:text-white">
          C’est prêt pour la prod ?
        </summary>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
          C’est une base solide MVP. Pour la prod, ajoute validation, emails, logs, protections et tests.
        </p>
      </details>
    </div>

    <div class="mt-10 flex flex-wrap gap-3">
      <a href="{{ route('trips.search') }}"
         class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-800
                dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100">
        Rechercher un trajet
      </a>

      @guest
        <a href="{{ route('login') }}"
           class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-sm hover:bg-slate-50
                  dark:border-slate-800 dark:bg-slate-900 dark:text-white dark:hover:bg-slate-800">
          Se connecter
        </a>
      @endguest
    </div>
  </div>
</section>
@endsection
