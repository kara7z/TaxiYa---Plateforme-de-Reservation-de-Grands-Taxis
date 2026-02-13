@extends('layouts.app')
@section('title', 'Rechercher un trajet — TaxiYa')

@section('content')
@php
  $cities = $cities ?? ['Rabat','Casablanca','Fès','Marrakech','Agadir','Safi'];
@endphp

<div class="mx-auto max-w-3xl">
  <x-card>
    <div class="flex items-start justify-between gap-3">
      <div>
        <h1 class="text-2xl font-extrabold tracking-tight">Rechercher un trajet</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Formulaire simple : Départ, Arrivée, Date (US‑001)</p>
      </div>
      <x-badge tone="info">Voyageur</x-badge>
    </div>

    <form class="mt-6 grid gap-4" action="/results" method="GET">
      <div class="grid gap-3 sm:grid-cols-2">
        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Départ</span>
          <select name="from" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
            <option value="" disabled selected>Choisir</option>
            @foreach($cities as $c)
              <option value="{{ $c }}">{{ $c }}</option>
            @endforeach
          </select>
        </label>

        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Arrivée</span>
          <select name="to" class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
            <option value="" disabled selected>Choisir</option>
            @foreach($cities as $c)
              <option value="{{ $c }}">{{ $c }}</option>
            @endforeach
          </select>
        </label>
      </div>

      <label class="block">
        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Date</span>
        <input type="date" name="date" required
               class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Conseil MVP : limite la date max à +14 jours côté serveur.</p>
      </label>

      <div class="mt-2 flex flex-wrap gap-3">
        <x-button type="submit" class="w-full sm:w-auto">
          <i data-lucide="search" class="h-4 w-4"></i>
          Voir les trajets
        </x-button>
        <x-button as="a" href="/" variant="secondary" class="w-full sm:w-auto">
          <i data-lucide="arrow-left" class="h-4 w-4"></i>
          Retour
        </x-button>
      </div>
    </form>
  </x-card>
</div>
@endsection
