@extends('layouts.app')
@section('title', 'Inscription chauffeur — TaxiYa')

@section('content')
<div class="mx-auto max-w-lg">
  <x-card>
    <div class="flex items-start justify-between gap-3">
      <div>
        <h1 class="text-2xl font-extrabold tracking-tight">Inscription chauffeur</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Nom • Email • Téléphone (US‑101)</p>
      </div>
      <x-badge tone="warning">Validation admin</x-badge>
    </div>

    <form class="mt-6 grid gap-3" method="POST" action="{{ route('driver.register.store') }}">
      @csrf

      <label class="block">
        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Nom complet</span>
        <input type="text" name="name" required
               class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
      </label>

      <label class="block">
        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Email</span>
        <input type="email" name="email" required
               class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
      </label>

      <label class="block">
        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Mot de passe</span>
        <input type="password" name="password" required
               class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
      </label>

      <x-button type="submit" class="w-full mt-2">
        Créer mon compte
      </x-button>

      <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/30">
        <div class="font-semibold">Après inscription</div>
        <p class="mt-1 text-slate-600 dark:text-slate-400">
          Tu seras redirigé vers la page <span class="font-semibold">“En attente de validation”</span>.
        </p>
        <div class="mt-3">
          <x-button as="a" href="/driver/login" variant="secondary">J'ai déjà un compte</x-button>
        </div>
      </div>
    </form>
  </x-card>

  <div class="mt-4 text-center text-sm text-slate-600 dark:text-slate-400">
    Retour voyageur : <a href="/search" class="font-semibold text-brand-600 hover:text-brand-500">rechercher un trajet</a>
  </div>
</div>
@endsection
