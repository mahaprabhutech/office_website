@if($paginator->hasPages())
    <nav class="pagination" aria-label="Pagination">
        <span class="pagination-summary">
            Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }}
        </span>
        <div class="pagination-links">
            @if($paginator->onFirstPage())
                <span class="page-link is-disabled">Previous</span>
            @else
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
            @endif

            @foreach($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                <a class="page-link {{ $page === $paginator->currentPage() ? 'is-current' : '' }}" href="{{ $url }}">{{ $page }}</a>
            @endforeach

            @if($paginator->hasMorePages())
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
            @else
                <span class="page-link is-disabled">Next</span>
            @endif
        </div>
    </nav>
@endif
