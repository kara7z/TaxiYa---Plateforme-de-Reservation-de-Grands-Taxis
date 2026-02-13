@php
    $isBooked = in_array($seat->id, $bookedSeatIds ?? []);
@endphp

<label class="relative group h-16">
    <input type="checkbox" name="seats[]" value="{{ $seat->id }}" 
           class="peer hidden" 
           {{ $isBooked ? 'disabled' : '' }}
           @change="if($el.checked) { selectedSeats.push({{ $seat->id }}) } else { selectedSeats = selectedSeats.filter(id => id !== {{ $seat->id }}) }">
    
    <div class="h-full w-full flex flex-col items-center justify-center rounded-xl border-2 transition-all duration-200
        {{ $isBooked 
            ? 'bg-slate-300 dark:bg-slate-800 border-transparent text-slate-500 cursor-not-allowed' 
            : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 cursor-pointer hover:border-brand-500 peer-checked:bg-brand-600 peer-checked:border-brand-600 peer-checked:text-white shadow-sm' 
        }}">
        <span class="text-xs font-bold uppercase">S{{ $seat->seat_number }}</span>
        <span class="text-[9px] uppercase opacity-60">{{ $seat->type }}</span>
    </div>
</label>