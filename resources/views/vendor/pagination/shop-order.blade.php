@if ($paginator->hasPages())
<div class="text-[10px] py-[20px] mb-6">
  <p>
    <!-- 前へ移動ボタン -->
    @if ($paginator->onFirstPage())
    @else
    <a href="{{ $paginator->url(1) }}" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">&lt;&lt;</a>
    <a href="{{ $paginator->previousPageUrl() }}" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">&lt;</a>
    @endif
    @foreach ($elements as $element)
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span class="text-white bg-gray-300  m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden">{{ $page }}</span>
    @else
    <a href="{{ $url }}" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach
    <!-- 次へ移動ボタン -->
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">&gt;</a>
    <a href="{{ $paginator->lastPage() }}" class="text-gray-900 bg-white m-0 mr-2 p-1 pb-0.5 border border-gray-300 float-left w-6 text-center no-underline overflow-hidden hover:text-white hover:bg-gray-300">&gt;&gt;</a> 
    @endif
  </p>
</div>
@endif
