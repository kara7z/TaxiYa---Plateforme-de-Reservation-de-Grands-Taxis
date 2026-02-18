@extends('layouts.app')
@section('title', 'Créer un trajet — Chauffeur — TaxiYa')

@section('content')

<div class="mx-auto max-w-3xl">
  <x-card>
    <div class="flex items-start justify-between gap-3">
      <div>
        <h1 class="text-2xl font-extrabold tracking-tight">Créer un trajet</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Départ • Arrivée • Date • Heure • Prix/place (US‑102)</p>
      </div>
      <x-badge tone="info">Chauffeur</x-badge>
    </div>

    <form class="mt-6 grid gap-4" method="POST" action="{{ route('driver.trips.store') }}">
      @csrf

      @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-400">
          <ul class="list-inside list-disc">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="grid gap-3 sm:grid-cols-2">
        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Départ</span>
          <select name="from" id="fromCity" required 
                  class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
            <option value="" disabled selected>Choisir</option>
            @foreach($cities as $c)
              <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
          </select>
        </label>

        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Arrivée</span>
          <select name="to" id="toCity" required
                  class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
            <option value="" disabled selected>Choisir</option>
            @foreach($cities as $c)
              <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
          </select>
        </label>
      </div>



      <div class="grid gap-3 sm:grid-cols-3">
        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Date</span>
          <input type="date" name="date" required
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>

        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Heure</span>
          <input type="time" name="time" required
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>

        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Prix / place (DH)</span>
          <input type="number" id='base_price' name="price" min="10" step="1" required placeholder="min price :___"
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>
      </div>

      <div class="grid gap-3 sm:grid-cols-2">
        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Heure d'arrivée estimée</span>
          <input type="time" name="estimated_arrival" required
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>
      </div>

      <div class="grid gap-3 sm:grid-cols-2">
        <label class="block">
          <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">Plage de retard (minutes)</span>
          <input type="number" name="range_of_lateness" min="0" step="1" required placeholder="ex: 15"
                 class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm shadow-sm outline-none focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
        </label>

        <label class="flex items-center gap-2 mt-6">
          <input type="checkbox" name="repeat_next_7_days"
                 class="rounded border-slate-200 text-brand-600 shadow-sm focus:ring-4 focus:ring-brand-500/20 dark:border-slate-800 dark:bg-slate-900">
          <span class="text-sm text-slate-600 dark:text-slate-400">Ajouter ce trajet pour les 7 prochains jours</span>
        </label>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/30">
        <div class="font-semibold">Statut MVP</div>
        <p class="mt-1 text-slate-600 dark:text-slate-400">
          Après création : trajet visible dans la recherche avec statut “en attente de réservations”.
        </p>
      </div>

      <div class="flex flex-wrap gap-3">
        <x-button type="submit">
          <i data-lucide="save" class="h-4 w-4"></i>
          Publier
        </x-button>
        <x-button as="a" href="/driver/trips" variant="secondary">
          Annuler
        </x-button>
      </div>
    </form>
  </x-card>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {

    const fromCity = document.getElementById("fromCity");
    const toCity = document.getElementById("toCity");
    const basePriceInput = document.getElementById("base_price");

    // ✅ Laravel-generated URL
    const basePriceUrl = "{{ route('driver.trips.route_base_price') }}";

    function fetchBasePrice() {
        const from = fromCity.value;
        const to = toCity.value;

        if (!from || !to) {
            basePriceInput.value = "";
            basePriceInput.min = 10;
            basePriceInput.placeholder = "Prix de base : ___ DH";
            return;
        }

        fetch(`${basePriceUrl}?from=${from}&to=${to}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('HTTP error ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('base price response:', data);

                if (data.base_price !== null) {
                    const price = parseInt(data.base_price);

                    basePriceInput.min = price;
                    basePriceInput.value = price;
                    basePriceInput.placeholder = `Prix de base : ${price} DH`;
                } else {
                    basePriceInput.value = "";
                    basePriceInput.min = 10;
                    basePriceInput.placeholder = "Aucun prix de base pour ce trajet";
                }
            })
            .catch(error => {
                console.error('Error fetching base price:', error);
            });
    }

    fromCity.addEventListener("change", function () {
        const fromValue = fromCity.value;

        [...toCity.options].forEach(option => {
            option.hidden = option.value === fromValue;
        });

        if (toCity.value === fromValue) {
            toCity.value = "";
        }

        fetchBasePrice();
    });

    toCity.addEventListener("change", fetchBasePrice);
});
</script>


<!-- <script>
  document.addEventListener('DOMContentLoaded', function () {

    const fromCity = document.getElementById("fromCity");
    const toCity = document.getElementById("toCity");
    const basePriceInput = document.getElementById("base_price");

    function fetchBasePrice() {
      const from = fromCity.value;
      const to = toCity.value;

      if (!from || !to) {
        basePriceInput.value = "";
        basePriceInput.min = 10;
        basePriceInput.placeholder = "Prix de base :___ DH";
        return;
      }

      fetch(`/basePrice?from=${from}&to=${to}`)
        .then(response => response.json())
        .then(data => {
          console.log('base price response:', data);

          if (data.base_price !== null) {
            const price = parseInt(data.base_price);

            basePriceInput.min = price;
            basePriceInput.value = price;
            basePriceInput.placeholder = `Prix de base : ${price} DH`;

          } else {
            basePriceInput.value = "";
            basePriceInput.min = 10;
            basePriceInput.placeholder = "Prix de base : ___ DH";
          }
        })
    .catch(error => {
      console.error('Error fetching base price:', error);
    });
    }

    fromCity.addEventListener("change", function () {
      console.log('from city:', fromCity.value);

      const fromValue = fromCity.value;

      [...toCity.options].forEach(option => {
        option.hidden = option.value === fromValue;
      });

      if (toCity.value === fromValue) {
        toCity.value = "";
      }

      fetchBasePrice();
    });

    toCity.addEventListener("change", function () {
      console.log('to city:', toCity.value);
      fetchBasePrice();
    });

  });
</script> -->
