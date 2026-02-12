@extends('layouts.app')

@section('title', 'TaxiYa — Réserver une place en Grand Taxi')

@section('content')
@php
  $cities = $cities ?? ['Rabat','Casablanca','Fès','Marrakech','Agadir','Safi'];
@endphp

<div class="grid gap-6 lg:grid-cols-12">
  <div class="lg:col-span-7">
    <x-card class="relative overflow-hidden">
      <div class="absolute -right-20 -top-20 h-56 w-56 rounded-full bg-brand-500/20 blur-2xl"></div>
      <div class="absolute -left-24 -bottom-24 h-64 w-64 rounded-full bg-emerald-500/15 blur-2xl"></div>

      <div class="relative">
        <x-badge tone="info">Prototype — MVP (5 jours)</x-badge>

        <h1 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
          Les Grands Taxis, <span class="text-brand-600">sans le chaos</span>.
        </h1>

        <p class="mt-4 text-slate-600 dark:text-slate-300">
          Réserve une place précise, connais l’heure de départ, et évite l’attente « jusqu’à remplir 6 places ».
        </p>

        <div class="mt-6 flex flex-wrap gap-3">
          <x-button as="a" href="/search">
            <i data-lucide="search" class="h-4 w-4"></i>
            Rechercher un trajet
          </x-button>
          <x-button as="a" href="/driver/register" variant="secondary">
            <i data-lucide="badge-check" class="h-4 w-4"></i>
            Je suis chauffeur
          </x-button>
        </div>

        <div class="mt-8 grid gap-3 sm:grid-cols-3">
          <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="text-xs text-slate-500">Réservation</div>
            <div class="mt-1 text-sm font-semibold">1 place, 1 numéro</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="text-xs text-slate-500">Visibilité</div>
            <div class="mt-1 text-sm font-semibold">Heure + prix clair</div>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="text-xs text-slate-500">Chauffeurs</div>
            <div class="mt-1 text-sm font-semibold">Remplissage optimisé</div>
          </div>
        </div>
      </div>
    </x-card>

    <div class="mt-6 grid gap-4 sm:grid-cols-2">
      <x-card>
        <div class="flex items-start gap-3">
          <div class="grid h-10 w-10 place-items-center rounded-xl bg-brand-600 text-white">
            <i data-lucide="clock" class="h-5 w-5"></i>
          </div>
          <div>
            <div class="font-semibold">Départ garanti (prototype)</div>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
              L’utilisateur voit les départs planifiés (US‑001). Moins d’incertitude, plus de confiance.
            </p>
          </div>
        </div>
      </x-card>

      <x-card>
        <div class="flex items-start gap-3">
          <div class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-600 text-white">
            <i data-lucide="shield-check" class="h-5 w-5"></i>
          </div>
          <div>
            <div class="font-semibold">Places sécurisées</div>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
              Vue du taxi et sélection d’une place (US‑002). Une place ne peut être réservée qu’une fois (RB‑005).
            </p>
          </div>
        </div>
      </x-card>
    </div>
  </div>

  <!-- Quick search -->
  <div class="lg:col-span-5">
    <x-card>
      <div class="flex items-center justify-between">
        <div>
          <div class="text-sm font-semibold">Trouver un trajet</div>
          <div class="text-xs text-slate-500 dark:text-slate-400">Départ • Arrivée • Date</div>
        </div>
        <x-badge tone="success">Mobile‑first</x-badge>
      </div>

      <form class="mt-5 grid gap-3" action="/results" method="GET">
        <div class="grid gap-3 sm:grid-cols-2">
          <label class="block">
            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Départ</span>
            <select name="from" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
              @foreach($cities as $c)
                <option value="{{ $c }}">{{ $c }}</option>
              @endforeach
            </select>
          </label>

          <label class="block">
            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Arrivée</span>
            <select name="to" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
              @foreach($cities as $c)
                <option value="{{ $c }}">{{ $c }}</option>
              @endforeach
            </select>
          </label>
        </div>

        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Date</span>
          <input type="date" name="date"
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>

        <div class="mt-2 flex gap-3">
          <x-button type="submit" class="w-full">
            <i data-lucide="search" class="h-4 w-4"></i>
            Rechercher
          </x-button>
        </div>

        <p class="text-xs text-slate-500 dark:text-slate-400">
          Astuce : ajoute des filtres (US‑503) sur la page résultats.
        </p>
      </form>
    </x-card>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold">Pourquoi TaxiYa ?</div>
        <i data-lucide="sparkles" class="h-4 w-4 text-brand-600"></i>
      </div>
      <ul class="mt-4 grid gap-3 text-sm text-slate-600 dark:text-slate-400">
        <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-4 w-4 text-emerald-600"></i> Heure de départ visible</li>
        <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-4 w-4 text-emerald-600"></i> Places disponibles / 6</li>
        <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-4 w-4 text-emerald-600"></i> Réservation + email simple</li>
      </ul>
    </div>
  </div>
</div>
@endsection
