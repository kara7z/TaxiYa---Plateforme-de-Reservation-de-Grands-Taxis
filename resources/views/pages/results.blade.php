@extends('layouts.app')
@section('title', 'Résultats — TaxiYa')

@section('content')
@php
  // Fallback sample results if controller doesn't pass $trips
  $query = [
    'from' => request('from','Rabat'),
    'to' => request('to','Casablanca'),
    'date' => request('date', date('Y-m-d')),
  ];

  $trips = $trips ?? [
    ['id'=>1,'from'=>$query['from'],'to'=>$query['to'],'date'=>$query['date'],'time'=>'08:30','price'=>30,'available'=>4,'driver'=>'Hassan','status'=>'open'],
    ['id'=>2,'from'=>$query['from'],'to'=>$query['to'],'date'=>$query['date'],'time'=>'10:00','price'=>35,'available'=>2,'driver'=>'Amina','status'=>'open'],
    ['id'=>3,'from'=>$query['from'],'to'=>$query['to'],'date'=>$query['date'],'time'=>'13:30','price'=>25,'available'=>6,'driver'=>'Youssef','status'=>'open'],
    ['id'=>4,'from'=>$query['from'],'to'=>$query['to'],'date'=>$query['date'],'time'=>'18:00','price'=>40,'available'=>1,'driver'=>'Khalid','status'=>'open'],
  ];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Trajets disponibles</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
      {{ $query['from'] }} → {{ $query['to'] }} • {{ \Carbon\Carbon::parse($query['date'])->format('d/m/Y') }}
    </p>
  </div>

  <div class="flex gap-2">
    <x-button as="a" href="/search" variant="secondary">
      <i data-lucide="sliders-horizontal" class="h-4 w-4"></i>
      Modifier
    </x-button>
  </div>
</div>

<div class="grid gap-6 lg:grid-cols-12" x-data="{filtersOpen:false}">
  <!-- Filters -->
  <aside class="lg:col-span-4">
    <div class="sticky top-24 space-y-4">
      <x-card>
        <div class="flex items-center justify-between">
          <div class="text-sm font-semibold">Filtres (US‑503)</div>
          <button class="rounded-lg p-2 hover:bg-slate-100 dark:hover:bg-slate-900 lg:hidden" @click="filtersOpen=!filtersOpen">
            <i data-lucide="chevrons-up-down" class="h-4 w-4"></i>
          </button>
        </div>

        <div class="mt-4 space-y-4" :class="filtersOpen ? '' : 'hidden lg:block'">
          <label class="block">
            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Prix maximum</span>
            <input type="range" min="20" max="80" value="{{ (int)request('max_price', 60) }}" class="mt-2 w-full"
                   @input="$refs.priceValue.textContent = $event.target.value + ' DH'">
            <div class="mt-1 text-xs text-slate-500"><span x-ref="priceValue">{{ (int)request('max_price', 60) }} DH</span></div>
          </label>

          <div>
            <div class="text-xs font-semibold text-slate-600 dark:text-slate-400">Heure de départ</div>
            <div class="mt-2 grid grid-cols-3 gap-2">
              <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">Matin</button>
              <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">Après‑midi</button>
              <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">Soir</button>
            </div>
          </div>

          <div>
            <div class="text-xs font-semibold text-slate-600 dark:text-slate-400">Type de place</div>
            <div class="mt-2 grid grid-cols-2 gap-2">
              <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">Avant</button>
              <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">Arrière</button>
            </div>
          </div>

          <div class="pt-2">
            <div class="text-xs font-semibold text-slate-600 dark:text-slate-400">Trier</div>
            <div class="mt-2 grid grid-cols-2 gap-2">
              <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">Par heure</button>
              <button type="button" class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">Par prix</button>
            </div>
          </div>

          <div class="flex gap-2 pt-2">
            <x-button variant="secondary" class="w-full">
              <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
              Reset
            </x-button>
          </div>

          <p class="text-xs text-slate-500 dark:text-slate-400">
            (Prototype UI) Connecte ces filtres à ta requête Eloquent.
          </p>
        </div>
      </x-card>

      <x-card>
        <div class="flex items-start gap-3">
          <div class="grid h-10 w-10 place-items-center rounded-xl bg-brand-600 text-white">
            <i data-lucide="info" class="h-5 w-5"></i>
          </div>
          <div>
            <div class="text-sm font-semibold">Affichage MVP</div>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
              Heure • places dispo/6 • prix. Clique pour choisir une place.
            </p>
          </div>
        </div>
      </x-card>
    </div>
  </aside>

  <!-- Results list -->
  <section class="lg:col-span-8">
    <div class="grid gap-4">
      @forelse($trips as $t)
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
          <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
              <div class="flex items-center gap-2">
                <div class="text-lg font-extrabold tracking-tight">{{ $t['time'] }}</div>
                <x-badge tone="{{ $t['available'] == 0 ? 'danger' : ($t['available'] <= 2 ? 'warning' : 'success') }}">
                  {{ $t['available'] }}/6 places
                </x-badge>
              </div>

              <div class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                {{ $t['from'] }} → {{ $t['to'] }} • Chauffeur: <span class="font-semibold">{{ $t['driver'] }}</span>
              </div>
            </div>

            <div class="text-right">
              <div class="text-sm text-slate-500 dark:text-slate-400">Prix / place</div>
              <div class="mt-1 text-2xl font-extrabold">{{ $t['price'] }} <span class="text-sm font-semibold">DH</span></div>
            </div>
          </div>

          <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
            <div class="text-xs text-slate-500 dark:text-slate-400">
              Statut : <span class="font-semibold">en attente de réservations</span>
            </div>

            <x-button as="a" href="/trip/{{ $t['id'] }}" class="w-full sm:w-auto" :disabled="$t['available'] == 0">
              <i data-lucide="seat" class="h-4 w-4"></i>
              Choisir une place
            </x-button>
          </div>
        </div>
      @empty
        <x-card>
          <div class="text-sm font-semibold">Aucun trajet</div>
          <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            Essaye une autre date ou un autre trajet.
          </p>
          <div class="mt-4">
            <x-button as="a" href="/search" variant="secondary">Retour à la recherche</x-button>
          </div>
        </x-card>
      @endforelse
    </div>
  </section>
</div>
@endsection
