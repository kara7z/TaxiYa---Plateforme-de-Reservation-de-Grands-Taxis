@extends('layouts.app')
@section('title', 'Mes trajets — Chauffeur — TaxiYa')

@section('content')
@php
  $trips = $trips ?? [
    ['id'=>11,'from'=>'Rabat','to'=>'Casablanca','date'=>date('Y-m-d'),'time'=>'10:00','price'=>35,'status'=>'open'],
    ['id'=>12,'from'=>'Rabat','to'=>'Casablanca','date'=>date('Y-m-d'),'time'=>'13:30','price'=>35,'status'=>'open'],
    ['id'=>13,'from'=>'Rabat','to'=>'Safi','date'=>date('Y-m-d', strtotime('+1 day')),'time'=>'09:00','price'=>90,'status'=>'open'],
  ];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Mes trajets</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Créer / gérer tes trajets (US‑102)</p>
  </div>

  <div class="flex gap-2">
    <x-button as="a" href="/driver/trips/create">
      <i data-lucide="plus" class="h-4 w-4"></i>
      Nouveau trajet
    </x-button>
    <x-button as="a" href="/driver/dashboard" variant="secondary">
      <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
      Dashboard
    </x-button>
  </div>
</div>

<div class="grid gap-4">
  @foreach($trips as $t)
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
          <div class="text-lg font-extrabold">{{ $t['from'] }} → {{ $t['to'] }}</div>
          <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $t['date'] }} • {{ $t['time'] }}</div>
        </div>

        <div class="text-right">
          <div class="text-xs text-slate-500 dark:text-slate-400">Prix/place</div>
          <div class="mt-1 text-xl font-extrabold">{{ $t['price'] }} <span class="text-sm font-semibold">DH</span></div>
        </div>
      </div>

      <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <x-badge tone="info">En attente de réservations</x-badge>

        <div class="flex flex-wrap gap-2">
          <x-button as="a" href="/driver/bookings" variant="secondary" size="sm">
            <i data-lucide="users" class="h-4 w-4"></i>
            Réservations
          </x-button>
          <x-button variant="ghost" size="sm">
            <i data-lucide="pencil" class="h-4 w-4"></i>
            Modifier
          </x-button>
          <x-button variant="danger" size="sm">
            <i data-lucide="trash-2" class="h-4 w-4"></i>
            Supprimer
          </x-button>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
