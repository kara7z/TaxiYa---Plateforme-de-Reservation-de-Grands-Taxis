@props([
  'seats' => null, // array of seats: [['pos'=>1,'status'=>'available|reserved', 'type'=>'front|back']]
  'selected' => null, // selected position
  'name' => 'seat_position',
  'basePrice' => 60, // price per seat (server-side, this is just UI)
  'frontMultiplier' => 1.2,
])

@php
  // Fallback sample seats if none passed
  if(!$seats){
    $seats = collect(range(1,6))->map(function($pos){
      return [
        'pos' => $pos,
        'status' => in_array($pos,[3,6]) ? 'reserved' : 'available',
        'type' => in_array($pos,[1,2]) ? 'front' : 'back',
      ];
    })->toArray();
  }
@endphp

<div
  x-data="{
    selected: {{ $selected ? (int)$selected : 'null' }},
    basePrice: {{ (float)$basePrice }},
    frontMultiplier: {{ (float)$frontMultiplier }},
    seatType(pos){
      const s = this.seats.find(x=>x.pos===pos);
      return s ? s.type : 'back';
    },
    seatPrice(pos){
      return this.seatType(pos)==='front' ? (this.basePrice*this.frontMultiplier) : this.basePrice;
    },
    formatDh(v){ return new Intl.NumberFormat('fr-MA', { maximumFractionDigits: 0 }).format(v) + ' DH'; },
    seats: @js($seats)
  }"
  class="space-y-4"
>
  <div class="flex items-center justify-between">
    <div class="text-sm font-semibold">Choisir une place</div>
    <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400">
      <span class="inline-flex items-center gap-1"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Dispo</span>
      <span class="inline-flex items-center gap-1"><span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span> Réservée</span>
      <span class="inline-flex items-center gap-1"><span class="h-2.5 w-2.5 rounded-full bg-brand-600"></span> Sélection</span>
    </div>
  </div>

  <!-- Taxi frame -->
  <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="mb-3 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
      <span class="inline-flex items-center gap-1"><i data-lucide="steering-wheel" class="h-4 w-4"></i> Avant</span>
      <span>Arrière</span>
    </div>

    <div class="grid grid-cols-3 gap-3">
      @foreach($seats as $seat)
        @php
          $pos = $seat['pos'];
          $reserved = $seat['status'] === 'reserved';
          $type = $seat['type'];
        @endphp

        <button
          type="button"
          @click="if(!{{ $reserved ? 'true' : 'false' }}) selected = {{ (int)$pos }}"
          class="group relative flex aspect-square flex-col items-center justify-center rounded-2xl border text-center transition
                 {{ $reserved ? 'cursor-not-allowed border-slate-200 bg-slate-100 text-slate-400 dark:border-slate-800 dark:bg-slate-950/40 dark:text-slate-600' : 'border-slate-200 bg-white hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:hover:bg-slate-800' }}"
          :class="selected === {{ (int)$pos }} ? 'border-brand-500 ring-4 ring-brand-500/20' : ''"
          aria-label="Place {{ $pos }}"
        >
          <div class="text-xl font-extrabold">#{{ $pos }}</div>
          <div class="mt-1 text-[11px] font-semibold {{ $reserved ? '' : ($type==='front' ? 'text-amber-600 dark:text-amber-300' : 'text-slate-500 dark:text-slate-400') }}">
            {{ $type === 'front' ? 'Avant (+20%)' : 'Arrière' }}
          </div>
          <div class="mt-1 text-[11px] text-slate-500 dark:text-slate-400"
               x-text="formatDh(seatPrice({{ (int)$pos }}))"></div>

          @if($reserved)
            <div class="absolute right-2 top-2 rounded-full bg-slate-200 px-2 py-1 text-[10px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">Pris</div>
          @endif
        </button>
      @endforeach
    </div>
  </div>

  <input type="hidden" name="{{ $name }}" :value="selected ?? ''">

  <div class="rounded-2xl border border-slate-200 bg-white p-4 text-sm shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-center justify-between">
      <div class="font-semibold">Résumé</div>
      <x-badge tone="info" x-text="selected ? ('Place #' + selected) : 'Aucune place'"></x-badge>
    </div>

    <div class="mt-3 flex items-center justify-between text-slate-600 dark:text-slate-400">
      <span>Prix</span>
      <span class="font-semibold text-slate-900 dark:text-slate-100" x-text="selected ? formatDh(seatPrice(selected)) : '--'"></span>
    </div>

    <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
      * Le calcul final peut être confirmé côté serveur (RB‑501 si activée).
    </p>
  </div>
</div>
