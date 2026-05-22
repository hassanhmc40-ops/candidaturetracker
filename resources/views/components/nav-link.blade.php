@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 border-l-[3px] border-indigo-500 dark:border-indigo-400 focus:outline-none focus:bg-indigo-100 dark:focus:bg-indigo-900/50 transition-colors'
            : 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 border-l-[3px] border-transparent focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
