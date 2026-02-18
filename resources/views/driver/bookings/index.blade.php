@extends('layouts.app')
@section('title', 'Réservations — Chauffeur — TaxiYa')

@section('content')
@php
  $bookings = $bookings ?? [
    ['id'=>201,'trip'=>'Rabat → Casablanca','time'=>'10:00','seat'=>2,'name'=>'Sara','email'=>'sara@mail.com','status'=>'confirmed'],
    ['id'=>202,'trip'=>'Rabat → Casablanca','time'=>'10:00','seat'=>5,'name'=>'Omar','email'=>'omar@mail.com','status'=>'confirmed'],
    ['id'=>203,'trip'=>'Rabat → Casablanca','time'=>'13:30','seat'=>1,'name'=>'Yassine','email'=>'yassine@mail.com','status'=>'confirmed'],
  ];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Réservations</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Liste des passagers + validation (bonus US‑502 QR)</p>
  </div>

  <div class="flex gap-2">
    <x-button as="a" href="/driver/dashboard" variant="secondary">
      <i data-lucide="arrow-left" class="h-4 w-4"></i>
      Dashboard
    </x-button>
  </div>
</div>

<div class="grid gap-4 lg:grid-cols-12">
  <section class="lg:col-span-7">
    <div class="grid gap-3">
      @foreach($bookings as $b)
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
          <div class="flex items-start justify-between gap-3">
            <div>
              <div class="font-semibold">{{ $b['trip'] }}</div>
              <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $b['time'] }} • Place(s): {{ $b['seat'] }}</div>
              <div class="mt-3 text-sm">
                <div class="font-semibold">{{ $b['name'] }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400">{{ $b['email'] }}</div>
              </div>
            </div>
            <x-badge tone="{{ $b['status'] === 'validated' ? 'success' : 'info' }}">
                {{ $b['status'] === 'validated' ? 'A bord' : 'Confirmée' }}
            </x-badge>
          </div>

          <div class="mt-4 flex flex-wrap gap-2 items-center">
            <div class="rounded-lg bg-slate-100 px-3 py-1.5 font-mono text-sm font-bold tracking-widest text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                #{{ $b['code'] }}
            </div>

            @if($b['status'] !== 'validated')
            <form action="{{ route('driver.bookings.validate', $b['id']) }}" method="POST">
                @csrf
                <x-button type="submit" size="sm">
                  <i data-lucide="check" class="h-4 w-4"></i>
                  Valider embarquement
                </x-button>
            </form>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <aside class="lg:col-span-5">
    <x-card>
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold">Scanner QR (bonus)</div>
        <i data-lucide="camera" class="h-4 w-4 text-brand-600"></i>
      </div>
      <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
        Ici tu peux intégrer une page caméra (WebRTC) pour scanner un QR et valider automatiquement (US‑502).
      </p>

      <div class="mt-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-sm text-slate-500 dark:border-slate-700 dark:bg-slate-950/30">
        Zone caméra (placeholder)
      </div>

      <div class="mt-4">
        <x-button class="w-full" variant="secondary">
          Ouvrir le scan
        </x-button>
      </div>
    </x-card>
  </aside>
</div>
@endsection
