<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-900">
            <h1 class="text-2xl font-semibold text-neutral-900 dark:text-white">Welkom bij het Magazijnportaal</h1>
            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-300">
                Gebruik de snelle links hieronder om direct naar de gewenste pagina te gaan.
            </p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            <a href="{{ route('leveringen.overzicht') }}" wire:navigate
                class="rounded-xl border border-neutral-200 bg-white p-4 text-center text-sm font-medium text-neutral-900 transition hover:border-blue-500 hover:text-blue-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:border-blue-400 dark:hover:text-blue-300">
                Overzicht geleverde producten
            </a>
            <a href="{{ url('/') }}" wire:navigate
                class="rounded-xl border border-neutral-200 bg-white p-4 text-center text-sm font-medium text-neutral-900 transition hover:border-blue-500 hover:text-blue-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:border-blue-400 dark:hover:text-blue-300">
                Home
            </a>
            <a href="{{ route('allergeen.producten.overzicht') }}" wire:navigate
                class="rounded-xl border border-neutral-200 bg-white p-4 text-center text-sm font-medium text-neutral-900 transition hover:border-blue-500 hover:text-blue-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:border-blue-400 dark:hover:text-blue-300">
                Overzicht Allergenen
            </a>
            <a href="{{ route('allergeen.index') }}" wire:navigate
                class="rounded-xl border border-neutral-200 bg-white p-4 text-center text-sm font-medium text-neutral-900 transition hover:border-blue-500 hover:text-blue-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:border-blue-400 dark:hover:text-blue-300">
                Allergenen
            </a>
            <a href="{{ route('magazijn.index') }}" wire:navigate
                class="rounded-xl border border-neutral-200 bg-white p-4 text-center text-sm font-medium text-neutral-900 transition hover:border-blue-500 hover:text-blue-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:border-blue-400 dark:hover:text-blue-300">
                Magazijn
            </a>
            <a href="{{ route('leverancier.index') }}" wire:navigate
                class="rounded-xl border border-neutral-200 bg-white p-4 text-center text-sm font-medium text-neutral-900 transition hover:border-blue-500 hover:text-blue-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:border-blue-400 dark:hover:text-blue-300">
                Leveranciers
            </a>
            <a href="{{ route('dashboard') }}" wire:navigate
                class="rounded-xl border border-neutral-200 bg-white p-4 text-center text-sm font-medium text-neutral-900 transition hover:border-blue-500 hover:text-blue-600 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100 dark:hover:border-blue-400 dark:hover:text-blue-300">
                Dashboard
            </a>
        </div>

        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
