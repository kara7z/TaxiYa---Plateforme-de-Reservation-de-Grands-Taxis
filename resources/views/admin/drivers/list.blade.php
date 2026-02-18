@extends('layouts.app')
@section('title', 'Chauffeurs — Admin — TaxiYa')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Gestion des Chauffeurs</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Liste de tous les chauffeurs</p>
  </div>

  <x-button as="a" href="{{ route('admin.dashboard') }}" variant="secondary">
    <i data-lucide="arrow-left" class="h-4 w-4"></i>
    Retour au Dashboard
  </x-button>
</div>

@if($drivers->isEmpty())
  <x-card>
    <div class="text-center py-12">
      <i data-lucide="users" class="h-16 w-16 mx-auto text-slate-400"></i>
      <p class="mt-4 text-xl font-semibold text-slate-800 dark:text-slate-200">Aucun chauffeur</p>
    </div>
  </x-card>
@else
  <div class="overflow-x-auto">
    <x-card>
      <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
        <thead class="bg-slate-50 dark:bg-slate-900">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Nom</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Statut</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
          @foreach($drivers as $driver)
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-slate-100">
                {{ $driver->name }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-slate-100">
                {{ $driver->email }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @if($driver->isValidated)
                  <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100">
                    Validé
                  </span>
                @else
                  <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100">
                    En attente
                  </span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <a href="{{ route('admin.drivers.show', $driver->id) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                    <i data-lucide="eye" class="h-4 w-4"></i>
                </a>
                
                <form method="POST" action="{{ route('admin.drivers.delete', $driver->id) }}" style="display: inline;" class="ml-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium" onclick="return confirm('⚠️ Confirmer la suppression de ce chauffeur ?')">
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                    </button>
                </form>
               </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </x-card>
  </div>
@endif
@endsection