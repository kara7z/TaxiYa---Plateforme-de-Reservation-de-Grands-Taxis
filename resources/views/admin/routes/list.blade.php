@extends('layouts.app')
@section('title', 'Routes Existantes — Admin — TaxiYa')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Routes Existantes</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Liste de toutes les routes disponibles</p>
  </div>

  <div class="flex gap-3">
    <x-button as="a" href="{{ route('admin.routes.create') }}" class="bg-green-600 hover:bg-green-700">
      <i data-lucide="plus" class="h-4 w-4"></i>
      Ajouter une Route
    </x-button>
    
    <x-button as="a" href="{{ route('admin.dashboard') }}" variant="secondary">
      <i data-lucide="arrow-left" class="h-4 w-4"></i>
      Retour
    </x-button>
  </div>
</div>

@if(session('success'))
  <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
    {{ session('error') }}
  </div>
@endif

@if($routes->isEmpty())
  <x-card>
    <div class="text-center py-12">
      <i data-lucide="map" class="h-16 w-16 mx-auto text-slate-400"></i>
      <p class="mt-4 text-xl font-semibold text-slate-800 dark:text-slate-200">Aucune route créée</p>
      <p class="mt-2 text-slate-600 dark:text-slate-400">Commencez par créer votre première route</p>
    </div>
  </x-card>
@else
  <div class="overflow-x-auto">
    <x-card>
      <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
        <thead class="bg-slate-50 dark:bg-slate-900">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Départ</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Arrivée</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Prix (MAD)</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Créée le</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
          @foreach($routes as $route)
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-slate-100">
                {{ $route->startCity->name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                {{ $route->arrivalCity->name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900 dark:text-slate-100">
                {{ number_format($route->base_price, 2) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                {{ $route->created_at->format('d/m/Y') }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400">
                <form method="POST" action="{{ route('admin.routes.delete', $route->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Confirmer la suppression de cette route ?')">
                    <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </x-card>
    
    <div class="mt-4 text-sm text-slate-600 dark:text-slate-400">
      <strong>Total :</strong> {{ $routes->count() }} route{{ $routes->count() > 1 ? 's' : '' }}
    </div>
  </div>
@endif
@endsection