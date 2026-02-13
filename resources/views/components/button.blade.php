@props([
  'as' => 'button',
  'variant' => 'primary', // primary|secondary|ghost|danger
  'size' => 'md', // sm|md|lg
])

@php
  $base = 'inline-flex items-center justify-center gap-2 rounded-xl font-semibold transition focus:outline-none focus:ring-4 focus:ring-brand-500/20';
  $sizes = [
    'sm' => 'px-3 py-2 text-sm',
    'md' => 'px-4 py-2.5 text-sm',
    'lg' => 'px-5 py-3 text-base'
  ][$size] ?? 'px-4 py-2.5 text-sm';

  $variants = [
    'primary' => 'bg-brand-600 text-white hover:bg-brand-500 shadow-sm',
    'secondary' => 'bg-white text-slate-900 hover:bg-slate-50 border border-slate-200 shadow-sm dark:bg-slate-900 dark:text-slate-100 dark:border-slate-800 dark:hover:bg-slate-800',
    'ghost' => 'bg-transparent text-slate-900 hover:bg-slate-100 dark:text-slate-100 dark:hover:bg-slate-900',
    'danger' => 'bg-rose-600 text-white hover:bg-rose-500 shadow-sm'
  ][$variant] ?? 'bg-brand-600 text-white hover:bg-brand-500';
@endphp

@if($as === 'a')
  <a {{ $attributes->merge(['class' => $base.' '.$sizes.' '.$variants]) }}>
    {{ $slot }}
  </a>
@else
  <button {{ $attributes->merge(['class' => $base.' '.$sizes.' '.$variants, 'type' => $attributes->get('type','button')]) }}>
    {{ $slot }}
  </button>
@endif
