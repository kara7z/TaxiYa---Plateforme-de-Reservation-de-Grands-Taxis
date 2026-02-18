@extends('layouts.app')
@section('title', 'Dossier chauffeur — Admin — TaxiYa')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
  <div>
    <h1 class="text-2xl font-extrabold tracking-tight">Dossier chauffeur</h1>
    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Validation manuelle</p>
  </div>

  <x-button as="a" href="{{ route('admin.drivers.list') }}" variant="secondary">
    <i data-lucide="arrow-left" class="h-4 w-4"></i>
    Retour
  </x-button>
</div>

<div class="grid gap-6 lg:grid-cols-12">
  <section class="lg:col-span-7">
    <x-card>
      <div class="flex items-center justify-between">
        <div class="text-sm font-semibold">Infos</div>
        
        <!-- ✅ Badge selon le statut -->
        @if($driver->isValidated)
          <x-badge tone="success">Validé</x-badge>
        @else
          <x-badge tone="warning">En attente</x-badge>
        @endif
      </div>

      <div class="mt-5 grid gap-3 text-sm">
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Nom</span>
          <span class="font-semibold">{{ $driver->name }}</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Email</span>
          <span class="font-semibold">{{ $driver->email }}</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Téléphone</span>
          <span class="font-semibold">{{ $driver->phone ?? 'N/A' }}</span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-slate-600 dark:text-slate-400">Date demande</span>
          <span class="font-semibold">{{ $driver->created_at->format('d/m/Y H:i') }}</span>
        </div>
      </div>

      <!-- ✅ Boutons uniquement si chauffeur en attente -->
      @if(!$driver->isValidated)
        <div class="mt-6 flex flex-wrap gap-2 pt-4 border-t border-slate-200 dark:border-slate-800">
          <form method="POST" action="{{ route('admin.drivers.approve', $driver->id) }}" style="display:inline;">
            @csrf
            <x-button type="submit" size="sm" class="bg-green-600 hover:bg-green-700">
              <i data-lucide="check" class="h-4 w-4"></i>
              Approuver
            </x-button>
          </form>
          
          <form method="POST" action="{{ route('admin.drivers.reject', $driver->id) }}" style="display:inline;" 
                onsubmit="return confirm('⚠️ Confirmer le rejet de ce chauffeur ?');">
            @csrf
            <x-button type="submit" variant="danger" size="sm">
              <i data-lucide="x" class="h-4 w-4"></i>
              Refuser
            </x-button>
          </form>
        </div>
      @endif
    </x-card>
  </section>
</div>
@endsection