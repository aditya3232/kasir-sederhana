@if ($paginator->hasPages())
    <nav class="flex items-center gap-1">
        {{-- Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span
                class="px-3 py-1.5 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Sebelumnya
            </a>
        @endif

        {{-- Nomor halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 text-sm text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="px-3 py-1.5 text-sm font-medium text-white bg-indigo-600 border border-indigo-600 rounded-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Berikutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                Berikutnya
            </a>
        @else
            <span
                class="px-3 py-1.5 text-sm text-gray-400 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                Berikutnya
            </span>
        @endif
    </nav>
@endif
