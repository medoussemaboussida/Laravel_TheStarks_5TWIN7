@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation">
        <ul class="pagination pagination-modern justify-content-center mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link prev-link" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-angle-double-left"></i>
                        <span class="d-none d-sm-inline ms-1">Précédent</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link prev-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-angle-double-left"></i>
                        <span class="d-none d-sm-inline ms-1">Précédent</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link dots">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link current-page">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link page-number" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link next-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <span class="d-none d-sm-inline me-1">Suivant</span>
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link next-link" aria-label="@lang('pagination.next')">
                        <span class="d-none d-sm-inline me-1">Suivant</span>
                        <i class="fas fa-angle-double-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif