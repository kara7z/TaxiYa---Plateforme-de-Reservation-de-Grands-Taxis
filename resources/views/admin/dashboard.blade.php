@extends('layouts.app')
@section('title', 'Admin — TaxiYa')

@section('content')
@php
  $stats = $stats ?? ['drivers_pending'=>3,'trips_today'=>12,'bookings_today'=>38];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Admin</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Validation manuelle des chauffeurs (US‑101)</p>
  </div>

  <x-button as="a" href="/admin/drivers/pending">
    <i data-lucide="badge-check" class="h-4 w-4"></i>
    Chauffeurs en attente
  </x-button>
</div>

<div class="grid gap-4 sm:grid-cols-3">
  <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="text-xs text-slate-500 dark:text-slate-400">Chauffeurs en attente</div>
    <div class="mt-2 text-3xl font-extrabold">{{ $stats['drivers_pending'] }}</div>
  </div>
  <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="text-xs text-slate-500 dark:text-slate-400">Trajets aujourd’hui</div>
    <div class="mt-2 text-3xl font-extrabold">{{ $stats['trips_today'] }}</div>
  </div>
  <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="text-xs text-slate-500 dark:text-slate-400">Réservations aujourd’hui</div>
    <div class="mt-2 text-3xl font-extrabold">{{ $stats['bookings_today'] }}</div>
  </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-12">
  <section class="lg:col-span-7">
    <x-card>
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold">Raccourcis</div>
        <i data-lucide="settings" class="h-4 w-4 text-brand-600"></i>
      </div>

      <div class="mt-4 grid gap-3 sm:grid-cols-2">
        <a href="/admin/drivers/pending" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
          <div class="flex items-center justify-between">
            <div>
              <div class="font-semibold">Validation chauffeurs</div>
              <div class="text-sm text-slate-600 dark:text-slate-400">Approuver / Refuser</div>
            </div>
            <i data-lucide="badge-check" class="h-5 w-5 text-brand-600"></i>
          </div>
        </a>

        <a href="#" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
          <div class="flex items-center justify-between">
            <div>
              <div class="font-semibold">Gestion villes</div>
              <div class="text-sm text-slate-600 dark:text-slate-400">Liste des stops</div>
            </div>
            <i data-lucide="map" class="h-5 w-5 text-brand-600"></i>
          </div>
        </a>
      </div>
    </x-card>
  </section>

  <aside class="lg:col-span-5">
    <x-card>
      <div class="text-sm font-semibold">Note MVP</div>
      <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
        Pour la démo, l’admin valide juste un champ `is_approved` sur le chauffeur.
      </p>
      <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/30">
        <div class="font-semibold">Suggestion</div>
        <p class="mt-1 text-slate-600 dark:text-slate-400">
          Affiche un badge “En attente” dans l’espace chauffeur jusqu’à validation.
        </p>
      </div>
    </x-card>
  </aside>
</div>
@endsection
