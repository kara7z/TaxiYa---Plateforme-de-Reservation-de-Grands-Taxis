@extends('layouts.app')
@section('title', 'Réservation confirmée — TaxiYa')

@section('content')
<div class="mx-auto max-w-2xl py-8">
  <x-card class="text-center">
    <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-emerald-600 text-white shadow-lg animate-bounce-short">
      <i data-lucide="party-popper" class="h-8 w-8"></i>
    </div>

    <h1 class="mt-6 text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">Félicitations !</h1>
    
    <div class="mt-2 text-slate-600 dark:text-slate-400">
        @if(session('success'))
            <p class="text-lg font-medium text-emerald-600">{{ session('success') }}</p>
        @endif
        <p class="mt-1 text-sm">
            Un récapitulatif a été envoyé à <span class="font-bold text-slate-900 dark:text-white">{{ auth()->user()->email }}</span>.
        </p>
    </div>

    <div class="mt-8 grid gap-3 sm:grid-cols-2">
      <x-button as="a" href="{{ route('booking.index') }}" variant="secondary" class="h-12">
        <i data-lucide="ticket" class="h-5 w-5"></i>
        Mes réservations
      </x-button>
      <x-button as="a" href="{{ route('trips.search') }}" class="h-12 bg-brand-600 hover:bg-brand-700">
        <i data-lucide="search" class="h-5 w-5"></i>
        Trouver un autre trajet
      </x-button>
    </div>

    <div class="mt-10 rounded-2xl border border-dashed border-slate-300 bg-slate-50/50 p-6 text-left dark:border-slate-700 dark:bg-slate-900/50">
      <div class="flex items-center gap-2 font-bold text-slate-800 dark:text-slate-200">
          <i data-lucide="layers" class="h-4 w-4"></i>
          <span>Statut du MVP (Prototype)</span>
      </div>
      
      <div class="mt-4 grid gap-4 sm:grid-cols-2">
          <div class="space-y-1">
              <div class="text-xs font-bold uppercase text-slate-400 tracking-wider">Étape Suivante</div>
              <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Le chauffeur doit maintenant valider votre demande (Interface Chauffeur).</p>
          </div>
          <div class="space-y-1">
              <div class="text-xs font-bold uppercase text-slate-400 tracking-wider">Bonus Demo</div>
              <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Génération d'un QR Code unique pour l'embarquement.</p>
          </div>
      </div>
    </div>
  </x-card>
</div>
@endsection