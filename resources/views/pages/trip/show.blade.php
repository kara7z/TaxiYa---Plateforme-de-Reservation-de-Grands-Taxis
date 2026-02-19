@extends('layouts.app')
@section('title', 'Réserver une place — TaxiYa')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight">Réserver une place</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ $trip->route->startCity->name }} → {{ $trip->route->arrivalCity->name }} •
            {{ \Carbon\Carbon::parse($trip->departure_hour)->format('H:i') }} •
            {{ \Carbon\Carbon::parse($trip->date)->format('d/m/Y') }}
        </p>
    </div>

    <div class="flex gap-2">
        <x-button as="a"
            href="{{ route('trips.results', ['from' => $trip->route->startCity->name, 'to' => $trip->route->arrivalCity->name, 'date' => $trip->date]) }}"
            variant="secondary">
            <i data-lucide="arrow-left" class="h-4 w-4"></i>
            Retour
        </x-button>
    </div>
</div>

@php
    $taxi = $trip->taxi;
@endphp

<form action="{{ route('booking.store', $trip->id) }}" method="POST">
    @csrf

    <div class="grid gap-6 lg:grid-cols-12" x-data="{ selectedSeats: [] }">

        <section class="lg:col-span-7">
            <x-card>
                <div class="flex items-start justify-between gap-3 mb-6">
                    <div>
                        <div class="text-sm font-semibold">
                            Taxi • {{ $taxi?->licence_plate ?? '—' }}
                        </div>
                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                            Cliquez sur un siège pour le sélectionner.
                        </p>
                    </div>
                    <x-badge tone="info">6 Places Total</x-badge>
                </div>

                <div class="p-8 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <div class="max-w-[300px] mx-auto">
                        <div class="h-3 w-3/4 mx-auto bg-slate-300 dark:bg-slate-700 rounded-t-full mb-10"></div>

                        @if($taxi && $taxi->seats && $taxi->seats->count())
                            <div class="grid gap-8">
                                <div class="grid grid-cols-2 gap-10">
                                    <div class="h-16 flex items-center justify-center rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-400 text-xs italic border border-slate-300 dark:border-slate-700">
                                        Chauffeur
                                    </div>

                                    @include('partials.seat-item', [
                                        'seat' => $taxi->seats->where('seat_number', 1)->first(),
                                        'bookedSeatIds' => $bookedSeatIds
                                    ])
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    @foreach($taxi->seats->where('seat_number', '>', 1)->sortBy('seat_number') as $seat)
                                        @include('partials.seat-item', [
                                            'seat' => $seat,
                                            'bookedSeatIds' => $bookedSeatIds
                                        ])
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-sm text-red-600">
                                Aucun taxi (ou sièges) associé à ce voyage.
                            </div>
                        @endif
                    </div>
                </div>
            </x-card>
        </section>

        <aside class="lg:col-span-5">
            <div class="sticky top-24 space-y-4">
                <x-card>
                    <div class="text-sm font-semibold mb-4 border-b pb-2">Récapitulatif</div>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Taxi</span>
                            <span class="font-medium text-right">{{ $taxi?->model ?? '—' }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-500">Prix unitaire</span>
                            <span class="font-medium text-brand-600">{{ number_format($trip->price, 0) }} DH</span>
                        </div>

                        <div class="pt-2 flex justify-between border-t font-bold text-lg">
                            <span>Total</span>
                            <span x-text="(selectedSeats.length * {{ $trip->price }}) + ' DH'">0 DH</span>
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="text-sm font-semibold mb-4">Coordonnées</div>
                    <div class="grid gap-4">
                        <label class="block">
                            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Votre Email</span>
                            <input name="email" type="email" required placeholder="nom@exemple.com"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm focus:ring-4 focus:ring-brand-500/20 outline-none dark:border-slate-800 dark:bg-slate-900">
                        </label>

                        <x-button type="submit" class="w-full"
                            x-bind:disabled="selectedSeats.length === 0 || {{ $taxi ? 'false' : 'true' }}">
                            <i data-lucide="check-circle" class="h-4 w-4"></i>
                            Confirmer la réservation
                        </x-button>
                    </div>
                </x-card>

                <div class="flex justify-center gap-4 text-xs text-slate-500">
                    <div class="flex items-center gap-1"><span class="w-3 h-3 bg-white border rounded shadow-sm"></span> Libre</div>
                    <div class="flex items-center gap-1"><span class="w-3 h-3 bg-slate-300 rounded"></span> Occupé</div>
                    <div class="flex items-center gap-1"><span class="w-3 h-3 bg-brand-600 rounded"></span> Choisi</div>
                </div>
            </div>
        </aside>
    </div>
</form>
@endsection

