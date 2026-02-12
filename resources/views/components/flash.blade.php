@php
  $success = session('success');
  $error = session('error');
@endphp

@if($success || $error)
  <div class="mb-6" x-data="{show:true}" x-show="show" x-transition>
    <div class="rounded-2xl border p-4 shadow-sm {{ $success ? 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-900/40 dark:bg-emerald-900/20 dark:text-emerald-100' : 'border-rose-200 bg-rose-50 text-rose-800 dark:border-rose-900/40 dark:bg-rose-900/20 dark:text-rose-100' }}">
      <div class="flex items-start justify-between gap-3">
        <div class="text-sm font-semibold">
          {{ $success ?? $error }}
        </div>
        <button @click="show=false" class="rounded-lg p-1 hover:bg-black/5 dark:hover:bg-white/10">
          <i data-lucide="x" class="h-4 w-4"></i>
        </button>
      </div>
    </div>
  </div>
@endif
