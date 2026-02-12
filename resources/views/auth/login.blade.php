@extends('layouts.app')
@section('title', 'Connexion — TaxiYa')

@section('content')
<div class="mx-auto max-w-md">
  <x-card>
    <div class="text-center">
      <div class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-brand-600 text-white shadow-sm">
        <i data-lucide="log-in" class="h-6 w-6"></i>
      </div>
      <h1 class="mt-4 text-2xl font-extrabold tracking-tight">Connexion</h1>
      <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Voyageur</p>
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

      <div class="flex items-center justify-between text-xs text-slate-500">
        <label class="inline-flex items-center gap-2">
          <input type="checkbox" class="rounded border-slate-300 dark:border-slate-700">
          Rester connecté
        </label>
        <a href="#" class="font-semibold text-brand-600 hover:text-brand-500">Mot de passe oublié</a>
      </div>

      <x-button type="submit" class="w-full mt-2">
        Se connecter
      </x-button>

      <p class="mt-4 text-center text-sm text-slate-600 dark:text-slate-400">
        Pas de compte ?
        <a href="/register" class="font-semibold text-brand-600 hover:text-brand-500">Créer un compte</a>
      </p>

      <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-xs text-slate-600 dark:border-slate-800 dark:bg-slate-950/30 dark:text-slate-400">
        Pour la démo : tu peux brancher ça à Laravel Breeze / Fortify / Jetstream.
      </div>
    </form>
  </x-card>
</div>
@endsection
