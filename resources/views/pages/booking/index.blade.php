@extends('layouts.app')
@section('title', 'Mes réservations — TaxiYa')

@section('content')
@php
  $bookings = $bookings ?? [
    ['id'=>101,'from'=>'Rabat','to'=>'Casablanca','date'=>date('Y-m-d', strtotime('+1 day')),'time'=>'10:00','seat'=>2,'status'=>'upcoming'],
    ['id'=>102,'from'=>'Rabat','to'=>'Safi','date'=>date('Y-m-d', strtotime('-3 day')),'time'=>'08:30','seat'=>5,'status'=>'done'],
    ['id'=>103,'from'=>'Fès','to'=>'Marrakech','date'=>date('Y-m-d', strtotime('+5 day')),'time'=>'13:30','seat'=>1,'status'=>'upcoming'],
  ];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Mes réservations</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Historique + statuts clairs (bonus US‑501)</p>
  </div>
  <x-button as="a" href="/search">
    <i data-lucide="plus" class="h-4 w-4"></i>
    Nouvelle réservation
  </x-button>
</div>

<div class="grid gap-4">
  @foreach($bookings as $b)
    @php
      $tone = $b['status']==='upcoming' ? 'info' : ($b['status']==='done' ? 'success' : 'danger');
      $label = $b['status']==='upcoming' ? 'À venir' : ($b['status']==='done' ? 'Terminé' : 'Annulé');
    @endphp

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
          <div class="flex items-center gap-2">
            <div class="text-lg font-extrabold">{{ $b['from'] }} → {{ $b['to'] }}</div>
            <x-badge :tone="$tone">{{ $label }}</x-badge>
          </div>
          <div class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            {{ \Carbon\Carbon::parse($b['date'])->format('d/m/Y') }} • {{ $b['time'] }} • Place #{{ $b['seat'] }}
          </div>
        </div>

        <div class="flex flex-wrap gap-2">
          <x-button as="a" href="/trip/1" variant="secondary">
            <i data-lucide="eye" class="h-4 w-4"></i>
            Détails
          </x-button>

          @if($b['status']==='upcoming')
            <x-button variant="danger">
              <i data-lucide="x-circle" class="h-4 w-4"></i>
              Annuler
            </x-button>
          @endif
        </div>
      </div>

      <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/30">
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Référence</span>
          <span class="font-mono text-xs">BK-{{ $b['id'] }}</span>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
