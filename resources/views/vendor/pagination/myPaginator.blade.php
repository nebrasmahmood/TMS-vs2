@if ($paginator->hasPages())
    <ul class="pager">

        @if ($paginator->onFirstPage())
            <li class="disabled prev"><span>→ @lang('pagination.previous')</span></li>
        @else
            <li class="prev"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">→ @lang('pagination.previous')</a></li>
        @endif



            <?php
            $start = $paginator->currentPage() - 2; // show 3 pagination links before current
            $end = $paginator->currentPage() + 2; // show 3 pagination links after current
            if($start < 1) {
                $start = 1; // reset start to 1
                $end += 1;
            }
            if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
            ?>

            @if($start > 1)
                <li class="hidden-xs"><a href="{{ $paginator->url(1) }}">1</a></li>
                @if($paginator->currentPage() != 4)
                    {{-- "Three Dots" Separator --}}
                    <li><span>...</span></li>
                @endif
            @endif
            @for ($i = $start; $i <= $end; $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{$i}}</a>
                </li>
            @endfor
            @if($end < $paginator->lastPage())
                @if($paginator->currentPage() + 3 != $paginator->lastPage())
                    {{-- "Three Dots" Separator --}}
                    <li><span>...</span></li>
                @endif
                <li>
                    <a href="{{ $paginator->url($paginator->lastPage()) }}">{{$paginator->lastPage()}}</a>
                </li>
            @endif


{{--            @if($paginator->currentPage() > 3)--}}
{{--                <li class="hidden-xs"><a href="{{ $paginator->url(1) }}">1</a></li>--}}
{{--            @endif--}}
{{--            @if($paginator->currentPage() > 4)--}}
{{--                <li><span>...</span></li>--}}
{{--            @endif--}}
{{--            @foreach(range(1, $paginator->lastPage()) as $i)--}}
{{--                @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)--}}
{{--                    @if ($i == $paginator->currentPage())--}}
{{--                        <li class="active"><span>{{ $i }}</span></li>--}}
{{--                    @else--}}
{{--                        <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>--}}
{{--                    @endif--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--            @if($paginator->currentPage() < $paginator->lastPage() - 3)--}}
{{--                <li><span>...</span></li>--}}
{{--            @endif--}}
{{--            @if($paginator->currentPage() < $paginator->lastPage() - 2)--}}
{{--                <li class="hidden-xs"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>--}}
{{--            @endif--}}



{{--        @foreach ($elements as $element)--}}

{{--            @if (is_string($element))--}}
{{--                <li class="disabled"><span>{{ $element }}</span></li>--}}
{{--            @endif--}}



{{--            @if (is_array($element))--}}
{{--                @foreach ($element as $page => $url)--}}
{{--                    @if ($page == $paginator->currentPage())--}}
{{--                        <li class="active my-active"><span>{{ $page }}</span></li>--}}
{{--                    @else--}}
{{--                        <li><a href="{{ $url }}">{{ $page }}</a></li>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--        @endforeach--}}



        @if ($paginator->hasMorePages())
            <li  class="next"><a href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next') ←</a></li>
        @else
            <li class="disabled next"><span>@lang('pagination.next') ←</span></li>
        @endif
    </ul>
@endif
