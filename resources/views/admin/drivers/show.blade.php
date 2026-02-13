@extends('layouts.app')
@section('title', 'Dossier chauffeur — Admin — TaxiYa')

@section('content')
@php
  $driver = $driver ?? ['id'=>1,'name'=>'Hassan El Amrani','email'=>'hassan@mail.com','phone'=>'+212 6 11 11 11 11','status'=>'pending','created_at'=>date('Y-m-d', strtotime('-2 day'))];
@endphp

<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Dossier chauffeur</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Validation manuelle</p>
  </div>

  <x-button as="a" href="/admin/drivers/pending" variant="secondary">
    <i data-lucide="arrow-left" class="h-4 w-4"></i>
    Retour
  </x-button>
</div>

<div class="grid gap-6 lg:grid-cols-12">
  <section class="lg:col-span-7">
    <x-card>
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold">Infos</div>
        <x-badge tone="warning">En attente</x-badge>
      </div>

      <div class="mt-5 grid gap-3 text-sm">
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Nom</span>
          <span class="font-semibold">{{ $driver['name'] }}</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Email</span>
          <span class="font-semibold">{{ $driver['email'] }}</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Téléphone</span>
          <span class="font-semibold">{{ $driver['phone'] }}</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Date demande</span>
          <span class="font-semibold">{{ $driver['created_at'] }}</span>
        </div>
      </div>

      <div class="mt-6 flex flex-wrap gap-2">
        <x-button>
          <i data-lucide="check" class="h-4 w-4"></i>
          Approuver
        </x-button>
        <x-button variant="danger">
          <i data-lucide="x" class="h-4 w-4"></i>
          Refuser
        </x-button>
      </div>
    </x-card>
  </section>

  <aside class="lg:col-span-5">
    <x-card>
      <div class="text-sm font-semibold">Checklist MVP</div>
      <ul class="mt-4 grid gap-2 text-sm text-slate-600 dark:text-slate-400">
        <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-4 w-4 text-emerald-600"></i> Coordonnées complètes</li>
        <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-4 w-4 text-emerald-600"></i> Statut “pending/approved”</li>
        <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-4 w-4 text-emerald-600"></i> Accès dashboard après approval</li>
      </ul>
    </x-card>
  </aside>
</div>
@endsection
