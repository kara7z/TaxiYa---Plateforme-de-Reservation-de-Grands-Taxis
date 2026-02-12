@extends('layouts.app')
@section('title', 'Connexion chauffeur — TaxiYa')

@section('content')
<div class="mx-auto max-w-md">
  <x-card>
    <div class="text-center">
      <div class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-slate-900 text-white shadow-sm dark:bg-white dark:text-slate-900">
        <i data-lucide="steering-wheel" class="h-6 w-6"></i>
      </div>
      <h1 class="mt-4 text-2xl font-extrabold tracking-tight">Connexion chauffeur</h1>
      <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Accès dashboard</p>
    </div>

    <form class="mt-6 grid gap-3" method="POST" action="#">
      @csrf

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
        Accéder au dashboard
      </x-button>

      <p class="mt-4 text-center text-sm text-slate-600 dark:text-slate-400">
        Pas encore inscrit ?
        <a href="/driver/register" class="font-semibold text-brand-600 hover:text-brand-500">Créer un compte chauffeur</a>
      </p>

      <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900/40 dark:bg-amber-900/20 dark:text-amber-100">
        <div class="font-semibold">Si ton compte est “en attente”</div>
        <p class="mt-1">Affiche une page “En attente de validation” après login.</p>
      </div>
    </form>
  </x-card>
</div>
@endsection
