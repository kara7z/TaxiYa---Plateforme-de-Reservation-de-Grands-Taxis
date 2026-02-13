@extends('layouts.app')
@section('title', 'Mes réservations — TaxiYa')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">Mes réservations</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Suivi de vos trajets et codes de réservation.</p>
  </div>
  <x-button as="a" href="{{ route('trips.search') }}">
    <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
    Nouvelle réservation
  </x-button>
</div>

<div class="grid gap-4">
  @forelse($bookings as $b)
    @php
      $tone = $b->status === 'confirmed' ? 'success' : ($b->status === 'pending' ? 'info' : 'danger');
      $label = $b->status === 'confirmed' ? 'Confirmé' : ($b->status === 'pending' ? 'En attente' : 'Annulé');
    @endphp

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
      <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
          <div class="flex items-center gap-2">
            <div class="text-lg font-extrabold text-slate-900 dark:text-white">
                {{ $b->trip->route->startCity->name }} → {{ $b->trip->route->arrivalCity->name }}
            </div>
            <x-badge :tone="$tone">{{ $label }}</x-badge>
          </div>
          <div class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            <span class="flex items-center gap-1">
                <i data-lucide="calendar" class="h-3.5 w-3.5"></i>
                {{ \Carbon\Carbon::parse($b->trip->date)->format('d/m/Y') }}
                <span class="mx-1.5">•</span>
                <i data-lucide="clock" class="h-3.5 w-3.5"></i>
                {{ \Carbon\Carbon::parse($b->trip->departure_hour)->format('H:i') }}
            </span>
          </div>
        </div>

        <div class="text-right">
            <div class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Code</div>
            <div class="text-lg font-mono font-bold text-brand-600">{{ $b->code }}</div>
        </div>
      </div>

      <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-slate-50 pt-4 dark:border-slate-800">
        <div class="flex items-center gap-4 text-sm">
            <div class="flex items-center gap-1 text-slate-600 dark:text-slate-400">
                <i data-lucide="armchair" class="h-4 w-4"></i>
                {{ $b->seats->count() }} place(s)
            </div>
            <div class="font-bold text-slate-900 dark:text-white">
                Total: {{ number_format($b->price, 2) }} DH
            </div>
        </div>

        <div class="flex gap-2">
            <x-button as="a" href="{{ route('trips.show', $b->trip->id) }}" variant="secondary" size="sm">
              <i data-lucide="eye" class="h-4 w-4"></i>
              Détails
            </x-button>
        </div>
      </div>
    </div>
  @empty
    <div class="flex flex-col items-center justify-center py-20 text-center border-2 border-dashed border-slate-200 rounded-3xl dark:border-slate-800">
        <div class="mb-4 text-slate-300">
            <i data-lucide="ticket" class="h-12 w-12"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Aucun voyage trouvé</h3>
        <p class="text-slate-500">Vos réservations apparaîtront ici une fois confirmées.</p>
    </div>
  @endforelse
</div>
@endsection