{{-- Siluet sederhana jika belum ada file PNG/WebP di public/images/islands/{slug}.* --}}
@php
    $slug = $islandSlug ?? 'jawa';
@endphp
<div class="island-fallback-svg w-full h-full flex items-center justify-center p-4 opacity-90">
    @switch($slug)
        @case('jawa')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 120" class="max-h-full w-auto drop-shadow-lg" aria-hidden="true">
                <path fill="currentColor" class="text-black/85" d="M8 62c18-8 42-14 68-12 32 2 58 8 88 6 28-2 52-10 78-8 22 2 38 12 42 28 2 10-4 22-16 30-24 16-58 14-88 18-34 4-70 14-102 8-26-4-48-18-62-38-8-12-10-26-8-32z"/>
            </svg>
            @break
        @case('sumatra')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 280" class="max-h-full w-auto drop-shadow-lg" aria-hidden="true">
                <path fill="currentColor" class="text-black/85" d="M48 4c14 32 18 68 12 104-6 38-20 74-24 112-2 22 6 44 20 60l-8 4c-16-18-26-42-24-68 4-40 18-76 24-114 6-36 2-70-10-100l10-2z"/>
            </svg>
            @break
        @case('kalimantan')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 180" class="max-h-full w-auto drop-shadow-lg" aria-hidden="true">
                <path fill="currentColor" class="text-black/85" d="M30 40c28-18 64-22 96-12 32 10 56 34 64 64 6 24-4 50-24 68-28 24-68 28-104 20-36-8-64-32-72-64-6-28 4-56 40-76z"/>
            </svg>
            @break
        @case('sulawesi')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 200" class="max-h-full w-auto drop-shadow-lg" aria-hidden="true">
                <path fill="currentColor" class="text-black/85" d="M58 4c16 28 12 60-6 88-14 22-10 48 8 70 12 16 18 36 14 54l-20 4c6-22-2-44-16-62-22-28-26-60-10-92 10-20 22-38 30-62z"/>
            </svg>
            @break
        @case('papua')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 220" class="max-h-full w-auto drop-shadow-lg" aria-hidden="true">
                <path fill="currentColor" class="text-black/85" d="M28 12c20 8 36 28 40 52 4 28-8 56-6 84 2 32 18 60 42 72l-6 8c-28-14-48-46-50-82-2-30 10-58 6-86-4-22-18-40-34-48l8 0z"/>
            </svg>
            @break
        @case('bali')
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 120" class="max-h-full w-auto drop-shadow-lg" aria-hidden="true">
                <path fill="currentColor" class="text-black/85" d="M40 8c8 16 12 36 10 56-2 22-12 42-8 62 4 18 18 28 34 24l-4 10c-22 4-42-12-46-34-4-24 6-46 8-70 2-20-2-38-10-52l16 4z"/>
            </svg>
            @break
        @default
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" class="max-h-[min(50vh,240px)] w-auto opacity-60" aria-hidden="true">
                <circle cx="100" cy="100" r="70" fill="currentColor" class="text-black/50"/>
            </svg>
    @endswitch
</div>
