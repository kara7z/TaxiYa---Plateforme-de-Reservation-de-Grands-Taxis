@extends('layouts.app')
@section('title', 'Dashboard chauffeur — TaxiYa')

@section('content')
@php
  $driver = $driver ?? ['name'=>'Amina', 'status'=>'pending'];
  $stats = $stats ?? ['trips_today'=>2,'seats_reserved'=>7,'revenue_est'=>420];
  $upcoming = $upcoming ?? [
    ['id'=>11,'from'=>'Rabat','to'=>'Casablanca','date'=>date('Y-m-d'),'time'=>'10:00','reserved'=>4],
    ['id'=>12,'from'=>'Rabat','to'=>'Casablanca','date'=>date('Y-m-d'),'time'=>'13:30','reserved'=>2],
  ];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Dashboard chauffeur</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Bonjour {{ $driver['name'] }} 👋</p>
  </div>

  <div class="flex flex-wrap gap-2">
    <x-button type="button" as="a" href="/driver/trips/create">
      <i data-lucide="plus" class="h-4 w-4"></i>
      Créer un trajet
    </x-button>
    <x-button type="button" as="a" href="/driver/trips" variant="secondary">
      <i data-lucide="list" class="h-4 w-4"></i>
      Mes trajets
    </x-button>
  </div>
</div>

@if($driver['status']==='pending')
  <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-900 shadow-sm dark:border-amber-900/40 dark:bg-amber-900/20 dark:text-amber-100">
    <div class="flex items-start gap-3">
      <i data-lucide="hourglass" class="mt-1 h-5 w-5"></i>
      <div>
        <div class="font-semibold">En attente de validation</div>
        <p class="mt-1 text-sm">
          Ton compte doit être validé manuellement par l’admin (US‑101). Tu peux préparer tes trajets mais les publier après validation.
        </p>
      </div>
    </div>
  </div>
@endif

<div class="grid gap-4 sm:grid-cols-3">
  <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="text-xs text-slate-500 dark:text-slate-400">Trajets aujourd’hui</div>
    <div class="mt-2 text-3xl font-extrabold">{{ $stats['trips_today'] }}</div>
  </div>
  <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="text-xs text-slate-500 dark:text-slate-400">Places réservées</div>
    <div class="mt-2 text-3xl font-extrabold">{{ $stats['seats_reserved'] }}</div>
  </div>
  <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="text-xs text-slate-500 dark:text-slate-400">Revenu estimé</div>
    <div class="mt-2 text-3xl font-extrabold">{{ $stats['revenue_est'] }} <span class="text-base font-semibold">DH</span></div>
  </div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-12">
  <section class="lg:col-span-7">
    <x-card>
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold">Voyages à venir</div>
        <x-badge tone="info">US‑102</x-badge>
      </div>

      <div class="mt-4 grid gap-3">
        @foreach($upcoming as $t)
          <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-start justify-between">
              <div>
                <div class="font-semibold">{{ $t['from'] }} → {{ $t['to'] }}</div>
                <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $t['date'] }} • {{ $t['time'] }}</div>
              </div>
              <x-badge tone="{{ $t['reserved'] >= 5 ? 'warning' : 'success' }}">{{ $t['reserved'] }}/6 réservées</x-badge>
            </div>
            <div class="mt-3 flex gap-2">
              <x-button type="button" as="a" href="/driver/bookings" variant="secondary" size="sm">
                <i data-lucide="users" class="h-4 w-4"></i>
                Voir réservations
              </x-button>
              <x-button type="button" as="a" href="/driver/trips" variant="ghost" size="sm">
                <i data-lucide="pencil" class="h-4 w-4"></i>
                Gérer
              </x-button>
            </div>
          </div>
        @endforeach
      </div>
    </x-card>
  </section>

  <aside class="lg:col-span-5">
    <x-card>
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold">Actions rapides</div>
        <i data-lucide="zap" class="h-4 w-4 text-brand-600"></i>
      </div>

      <div class="mt-4 grid gap-3">
        <a href="{{ route('driver.trips.create') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
          <div class="flex items-center justify-between">
            <div>
              <div class="font-semibold">Créer un voyage</div>
              <div class="text-sm text-slate-600 dark:text-slate-400">Départ • Arrivée • Date • Heure • Prix</div>
            </div>
            <i data-lucide="plus-circle" class="h-5 w-5 text-brand-600"></i>
          </div>
        </a>

        <a href="/driver/bookings" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
          <div class="flex items-center justify-between">
            <div>
              <div class="font-semibold">Scanner / valider (bonus)</div>
              <div class="text-sm text-slate-600 dark:text-slate-400">QR Code — embarquement</div>
            </div>
            <i data-lucide="qr-code" class="h-5 w-5 text-brand-600"></i>
          </div>
        </a>
      </div>
    </x-card>
  </aside>
</div>
@endsection
