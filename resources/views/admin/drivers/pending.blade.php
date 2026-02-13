@extends('layouts.app')
@section('title', 'Chauffeurs en attente — Admin — TaxiYa')

@section('content')
@php
  $drivers = $drivers ?? [
    ['id'=>1,'name'=>'Hassan El Amrani','email'=>'hassan@mail.com','phone'=>'+212 6 11 11 11 11','created_at'=>date('Y-m-d', strtotime('-2 day'))],
    ['id'=>2,'name'=>'Amina B.','email'=>'amina@mail.com','phone'=>'+212 6 22 22 22 22','created_at'=>date('Y-m-d', strtotime('-1 day'))],
    ['id'=>3,'name'=>'Khalid R.','email'=>'khalid@mail.com','phone'=>'+212 6 33 33 33 33','created_at'=>date('Y-m-d')],
  ];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Chauffeurs en attente</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Validation manuelle (US‑101)</p>
  </div>

  <x-button as="a" href="/admin/dashboard" variant="secondary">
    <i data-lucide="arrow-left" class="h-4 w-4"></i>
    Admin
  </x-button>
</div>

<div class="grid gap-4">
  @foreach($drivers as $d)
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
          <div class="flex items-center gap-2">
            <div class="text-lg font-extrabold">{{ $d['name'] }}</div>
            <x-badge tone="warning">En attente</x-badge>
          </div>
          <div class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            {{ $d['email'] }} • {{ $d['phone'] }}
          </div>
          <div class="mt-1 text-xs text-slate-500 dark:text-slate-400">
            Demande: {{ $d['created_at'] }}
          </div>
        </div>

        <div class="flex flex-wrap gap-2">
          <x-button as="a" href="/admin/drivers/{{ $d['id'] }}" variant="secondary" size="sm">
            <i data-lucide="eye" class="h-4 w-4"></i>
            Voir
          </x-button>
          <x-button size="sm">
            <i data-lucide="check" class="h-4 w-4"></i>
            Approuver
          </x-button>
          <x-button variant="danger" size="sm">
            <i data-lucide="x" class="h-4 w-4"></i>
            Refuser
          </x-button>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
