@extends('layouts.app')
@section('title', 'Page introuvable — TaxiYa')

@section('content')
<div class="mx-auto max-w-xl text-center">
  <x-card>
    <div class="mx-auto grid h-12 w-12 place-items-center rounded-2xl bg-slate-900 text-white shadow-sm dark:bg-white dark:text-slate-900">
      <i data-lucide="search-x" class="h-6 w-6"></i>
    </div>
    <h1 class="mt-4 text-3xl font-extrabold tracking-tight">404</h1>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
      Cette page n’existe pas (ou a été déplacée).
    </p>
    <div class="mt-6 flex justify-center gap-3">
      <x-button as="a" href="/" variant="secondary">Accueil</x-button>
      <x-button as="a" href="/search">Rechercher</x-button>
    </div>
  </x-card>
</div>
@endsection
