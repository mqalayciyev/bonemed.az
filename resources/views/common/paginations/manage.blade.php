@if ($paginator->lastPage() > 1)
    <div class="box-footer clearfix">
        <ul class="pagination pagination-sm no-margin pull-right">
            <li style="display: {{ ($paginator->currentPage() == 1) ? ' none' : '' }}">
                <a href="{{ $paginator->url($paginator->currentPage()-1) }}"><i class="fa fa-caret-left"></i></a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li>
                    <a style="background: {{ ($paginator->currentPage() == $i) ? '#00a2e8' : '' }};color: {{ ($paginator->currentPage() == $i) ? '#fff' : '' }}"
                       href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li style="display: {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' none' : '' }}">
                <a href="{{ $paginator->url($paginator->currentPage()+1) }}"><i class="fa fa-caret-right"></i></a>
            </li>
        </ul>
    </div>
@endif