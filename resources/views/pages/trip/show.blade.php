@extends('layouts.app')
@section('title', 'Choisir une place — TaxiYa')

@section('content')
@php
  $trip = $trip ?? [
    'id'=>1,
    'from'=>request('from','Rabat'),
    'to'=>request('to','Casablanca'),
    'date'=>request('date', date('Y-m-d')),
    'time'=>'10:00',
    'price'=>35,
    'driver'=>['name'=>'Amina','phone'=>'+212 6 12 34 56 78'],
    'pickup'=>'Station Grand Taxi (centre-ville)',
    'notes'=>'Arriver 10 minutes avant.',
  ];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Réserver une place</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
      {{ $trip['from'] }} → {{ $trip['to'] }} • {{ $trip['time'] }} • {{ \Carbon\Carbon::parse($trip['date'])->format('d/m/Y') }}
    </p>
  </div>

  <div class="flex gap-2">
    <x-button as="a" href="/results?from={{ $trip['from'] }}&to={{ $trip['to'] }}&date={{ $trip['date'] }}" variant="secondary">
      <i data-lucide="arrow-left" class="h-4 w-4"></i>
      Retour
    </x-button>
  </div>
</div>

<div class="grid gap-6 lg:grid-cols-12">
  <section class="lg:col-span-7">
    <x-card>
      <div class="flex items-start justify-between gap-3">
        <div>
          <div class="text-sm font-semibold">Taxi • 6 places</div>
          <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Places disponibles = vert, réservées = gris (US‑002)</p>
        </div>
        <x-badge tone="info">RB‑001 • RB‑002 • RB‑005</x-badge>
      </div>

      <div class="mt-6">
        <x-seat-map :basePrice="$trip['price']" />
      </div>
    </x-card>
  </section>

  <aside class="lg:col-span-5">
    <div class="sticky top-24 space-y-4">
      <x-card>
        <div class="flex items-center justify-between">
          <div class="text-sm font-semibold">Détails du trajet</div>
          <i data-lucide="route" class="h-4 w-4 text-brand-600"></i>
        </div>

        <div class="mt-4 grid gap-3 text-sm">
          <div class="flex items-center justify-between">
            <span class="text-slate-600 dark:text-slate-400">Départ</span>
            <span class="font-semibold">{{ $trip['from'] }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-600 dark:text-slate-400">Arrivée</span>
            <span class="font-semibold">{{ $trip['to'] }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-600 dark:text-slate-400">Date</span>
            <span class="font-semibold">{{ \Carbon\Carbon::parse($trip['date'])->format('d/m/Y') }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-600 dark:text-slate-400">Heure</span>
            <span class="font-semibold">{{ $trip['time'] }}</span>
          </div>
        </div>

        <div class="mt-4 rounded-2xl border border-slate-200 bg-white p-4 text-sm shadow-sm dark:border-slate-800 dark:bg-slate-900">
          <div class="flex items-center justify-between">
            <span class="text-slate-600 dark:text-slate-400">Point de départ</span>
            <span class="font-semibold text-right">{{ $trip['pickup'] }}</span>
          </div>
          <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">{{ $trip['notes'] }}</div>
        </div>
      </x-card>

      <x-card>
        <div class="flex items-center justify-between">
          <div class="text-sm font-semibold">Chauffeur</div>
          <i data-lucide="user" class="h-4 w-4 text-brand-600"></i>
        </div>

        <div class="mt-4 flex items-center justify-between text-sm">
          <div>
            <div class="font-semibold">{{ $trip['driver']['name'] }}</div>
            <div class="text-xs text-slate-500 dark:text-slate-400">Téléphone: {{ $trip['driver']['phone'] }}</div>
          </div>
          <x-badge tone="success">Validé (demo)</x-badge>
        </div>
      </x-card>

      <!-- Booking CTA -->
      <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900"
           x-data="{ email: '' }">
        <div class="text-sm font-semibold">Finaliser la réservation</div>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Email de confirmation simple (MVP).</p>

        <form action="/booking/success" method="GET" class="mt-4 grid gap-3">
          <label class="block">
            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Email</span>
            <input name="email" type="email" required placeholder="ex: nom@gmail.com"
                   class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
          </label>

          <x-button type="submit" class="w-full">
            <i data-lucide="mail-check" class="h-4 w-4"></i>
            Confirmer
          </x-button>

          <p class="text-xs text-slate-500 dark:text-slate-400">
            Prototype : le paiement en ligne peut être simulé (pas obligatoire pour la démo).
          </p>
        </form>
      </div>
    </div>
  </aside>
</div>
@endsection
