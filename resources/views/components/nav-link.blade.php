@props(['active'])

@php
$baseClasses = ($active ?? false)
    ? 'inline-flex items-center px-3 py-2 border-b-2 border-white text-sm font-medium leading-5 text-white focus:outline-none focus:border-indigo-200 transition duration-150 ease-in-out rounded-t'
    : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-indigo-100 hover:text-white hover:bg-blue-600 focus:outline-none focus:text-white focus:bg-blue-600 transition duration-150 ease-in-out rounded-t';
@endphp

<a {{ $attributes->merge(['class' => $baseClasses]) }}>
    {{ $slot }}
</a>