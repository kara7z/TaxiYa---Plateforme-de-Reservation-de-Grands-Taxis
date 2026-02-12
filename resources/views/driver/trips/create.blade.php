@extends('layouts.app')
@section('title', 'Créer un trajet — Chauffeur — TaxiYa')

@section('content')
@php
  $cities = $cities ?? ['Rabat','Casablanca','Fès','Marrakech','Agadir','Safi'];
@endphp

<div class="mx-auto max-w-3xl">
  <x-card>
    <div class="flex items-start justify-between gap-3">
      <div>
        <h1 class="text-2xl font-extrabold tracking-tight">Créer un trajet</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Départ • Arrivée • Date • Heure • Prix/place (US‑102)</p>
      </div>
      <x-badge tone="info">Chauffeur</x-badge>
    </div>

    <form class="mt-6 grid gap-4" method="POST" action="#">
      @csrf

      <div class="grid gap-3 sm:grid-cols-2">
        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Départ</span>
          <select name="from" required
                  class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
            <option value="" disabled selected>Choisir</option>
            @foreach($cities as $c)
              <option value="{{ $c }}">{{ $c }}</option>
            @endforeach
          </select>
        </label>

        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Arrivée</span>
          <select name="to" required
                  class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
            <option value="" disabled selected>Choisir</option>
            @foreach($cities as $c)
              <option value="{{ $c }}">{{ $c }}</option>
            @endforeach
          </select>
        </label>
      </div>

      <div class="grid gap-3 sm:grid-cols-3">
        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Date</span>
          <input type="date" name="date" required
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>

        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Heure</span>
          <input type="time" name="time" required
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>

        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Prix / place (DH)</span>
          <input type="number" name="price" min="10" step="1" required placeholder="ex: 35"
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/30">
        <div class="font-semibold">Statut MVP</div>
        <p class="mt-1 text-slate-600 dark:text-slate-400">
          Après création : trajet visible dans la recherche avec statut “en attente de réservations”.
        </p>
      </div>

      <div class="flex flex-wrap gap-3">
        <x-button type="submit">
          <i data-lucide="save" class="h-4 w-4"></i>
          Publier
        </x-button>
        <x-button as="a" href="/driver/trips" variant="secondary">
          Annuler
        </x-button>
      </div>
    </form>
  </x-card>
</div>
@endsection
