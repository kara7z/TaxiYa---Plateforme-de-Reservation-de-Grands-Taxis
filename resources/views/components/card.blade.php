@props([
  'p' => 'p-5',
  'class' => ''
])
<div {{ $attributes->merge(['class' => 'glass rounded-2xl shadow-sm '.$p.' '.$class]) }}>
  {{ $slot }}
</div>
