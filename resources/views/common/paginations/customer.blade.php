@if ($paginator->lastPage() > 1)
    <ul class="store-pages">
        <li><span class="text-uppercase">@lang('content.Page'):</span></li>
        <li style="display: {{ ($paginator->currentPage() == 1) ? ' none' : '' }}">
            <a href="{{ $paginator->url($paginator->currentPage()-1) }}"><i class="fa fa-caret-left"></i></a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li>
                <a style="color: {{ ($paginator->currentPage() == $i) ? '#f00' : '' }}" href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li style="display: {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' none' : '' }}">
            <a href="{{ $paginator->url($paginator->currentPage()+1) }}"><i class="fa fa-caret-right"></i></a>
        </li>
    </ul>
@endif