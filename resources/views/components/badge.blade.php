@props([
  'tone' => 'default' // default|success|warning|danger|info
])

@php
  $map = [
    'default' => 'bg-slate-100 text-slate-700 dark:bg-slate-900 dark:text-slate-200',
    'success' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200',
    'warning' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-200',
    'danger'  => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-200',
    'info'    => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-200',
  ][$tone] ?? 'bg-slate-100 text-slate-700';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold '.$map]) }}>
  {{ $slot }}
</span>
