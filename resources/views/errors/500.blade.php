@extends('layouts.app')
@section('title', 'Erreur — TaxiYa')

@section('content')
<div class="mx-auto max-w-xl text-center">
  <x-card>
    <div class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-rose-600 text-white shadow-sm">
      <i data-lucide="alert-triangle" class="h-6 w-6"></i>
    </div>
    <h1 class="mt-4 text-2xl font-extrabold tracking-tight">Oups…</h1>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
      Une erreur est survenue. Réessaie, ou reviens plus tard.
    </p>
    <div class="mt-6 flex justify-center gap-3">
      <x-button as="a" href="/" variant="secondary">Accueil</x-button>
      <x-button as="a" href="/search">Rechercher</x-button>
    </div>
  </x-card>
</div>
@endsection
