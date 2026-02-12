@extends('layouts.app')
@section('title', 'Réservation confirmée — TaxiYa')

@section('content')
@php
  $email = request('email','voyageur@example.com');
@endphp

<div class="mx-auto max-w-2xl">
  <x-card class="text-center">
    <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-emerald-600 text-white shadow-sm">
      <i data-lucide="check-circle" class="h-7 w-7"></i>
    </div>

    <h1 class="mt-4 text-2xl font-extrabold tracking-tight">Réservation confirmée</h1>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
      Un email de confirmation a été envoyé à <span class="font-semibold">{{ $email }}</span>.
    </p>

    <div class="mt-6 grid gap-3 sm:grid-cols-2">
      <x-button as="a" href="/bookings" variant="secondary">
        <i data-lucide="list" class="h-4 w-4"></i>
        Voir mes réservations
      </x-button>
      <x-button as="a" href="/search">
        <i data-lucide="search" class="h-4 w-4"></i>
        Réserver un autre trajet
      </x-button>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 text-left text-sm shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div class="font-semibold">Pour la démo</div>
      <ul class="mt-2 grid gap-2 text-slate-600 dark:text-slate-400">
        <li class="flex gap-2"><i data-lucide="dot" class="mt-1 h-4 w-4"></i> Afficher un QR code (bonus US‑502)</li>
        <li class="flex gap-2"><i data-lucide="dot" class="mt-1 h-4 w-4"></i> Statut “à venir / terminé / annulé” (US‑501)</li>
      </ul>
    </div>
  </x-card>
</div>
@endsection
