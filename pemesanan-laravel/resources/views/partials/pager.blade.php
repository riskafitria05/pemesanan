@if ($paginator->hasPages())
<nav class="row" aria-label="Halaman">
  <span class="muted">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>
  <span>
    @if($paginator->onFirstPage())<span class="btn ghost sm" aria-disabled="true" style="opacity:.5">Sebelumnya</span>
    @else<a class="btn ghost sm" href="{{ $paginator->previousPageUrl() }}">Sebelumnya</a>@endif
    @if($paginator->hasMorePages())<a class="btn ghost sm" href="{{ $paginator->nextPageUrl() }}">Berikutnya</a>
    @else<span class="btn ghost sm" aria-disabled="true" style="opacity:.5">Berikutnya</span>@endif
  </span>
</nav>
@endif
