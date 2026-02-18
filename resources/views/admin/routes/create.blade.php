@extends('layouts.app')
@section('title', 'Créer une Route — Admin — TaxiYa')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Créer une nouvelle Route</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Ajouter un trajet entre deux villes</p>
  </div>

  <x-button as="a" href="{{ route('admin.dashboard') }}" variant="secondary">
    <i data-lucide="arrow-left" class="h-4 w-4"></i>
    Retour au Dashboard
  </x-button>
</div>

<div class="max-w-2xl">
  <x-card>
    <form method="POST" action="{{ route('admin.routes.store') }}">
      @csrf
      
      <!-- Ville de départ -->
      <div class="mb-4">
        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
          Ville de Départ <span class="text-red-500">*</span>
        </label>
        <select name="start_city_id" class="w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-800" required>
          <option value="">Sélectionnez une ville</option>
          @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
        @error('start_city_id')
          <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <!-- Ville d'arrivée -->
      <div class="mb-4">
        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
          Ville d'Arrivée <span class="text-red-500">*</span>
        </label>
        <select name="arrival_city_id" class="w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-800" required>
          <option value="">Sélectionnez une ville</option>
          @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
        @error('arrival_city_id')
          <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <!-- Prix de base -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
          Prix de Base (MAD) <span class="text-red-500">*</span>
        </label>
        <input type="number" name="base_price" step="0.01" min="10" 
               class="w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-800" 
               placeholder="Ex: 100" required>
        @error('base_price')
          <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <!-- Boutons -->
      <div class="flex gap-3">
        <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700">
          <i data-lucide="plus" class="h-4 w-4"></i>
          Créer la Route
        </x-button>
        
        <x-button as="a" href="{{ route('admin.dashboard') }}" variant="secondary">
          Annuler
        </x-button>
      </div>
    </form>
  </x-card>
</div>
@endsection