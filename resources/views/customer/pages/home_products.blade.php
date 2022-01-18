@if(count($products))
<div class="card-columns">

    @foreach($products as $array => $product)
        {{-- <div class="panel panel-default">
            <div class="panel-body">A Basic Panel</div>
        </div> --}}
            <div class="product product-single card bg-white" style="position: relative">
                <div class="product-thumb">
                    <div class="product-label">
                        <span>@lang('content.New')</span>
                        @if($product->discount>0)
                            <span class="sale">{{- $product->discount }}%</span>
                        @endif
                    </div>
                    <button class="main-btn quick-view" data-toggle="modal"
                            data-target="#quick_view{{ $product->id }}">
                        <i class="fa fa-search-plus"></i> @lang('content.Quick view')
                    </button>
                    <a href="{{ route('product', $product->slug) }}">
                        <img src="{{ $product->image->image_name ? asset('img/products/'. $product->image->image_name) : 'http://via.placeholder.com/1200x1200?text=ProductPhoto' }}"
                            alt="{{ $product->product_name }}">
                    </a>
                </div>
                <div class="product-body">
                    <h3 class="product-price">{{ $product->sale_price }} ‎₼</h3>
                    <h2 class="product-name">
                        <a href="{{ route('product', $product->slug) }}">{{ $product->product_name }}</a>
                    </h2>
                    <div class="product-rating" style="width: 100%">
                        @if($product->id)
                            @php $rating = \App\Models\Rating::select(DB::raw('avg(rating.rating) AS rating_avg'))->where(['product_id' => $product->id])->get() @endphp
                        @endif

                        @for($count=1; $count<=5; $count++)
                            @if($count<=$rating[0]['rating_avg'])
                                @php $color = '' @endphp
                            @else
                                @php $color = '-o empty' @endphp
                            @endif
                            <i title="{{ $count }}" id="{{ $product->id.'-'.$count }}" data-index="{{ $count }}" data-product_id="{{ $product->id }}" data-rating="{{ $rating[0]['rating_avg'] }}" class="rating fa fa-star{{ $color }}"></i>
                        @endfor
                    </div>
                    
                    <div class="product-btns">
                        <button type="button" class="main-btn icon-btn add-wish-list"
                                data-id="{{ $product->id }}"><i
                                    class="fa fa-heart"></i></button>
                        <button class="main-btn icon-btn add-to-compare" data-id="{{ $product->id }}"><i class="fa fa-exchange"></i></button>
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <button type="submit" class="primary-btn add-to-cart" id="{{ $product->id }}">
                            <i class="fa fa-shopping-cart"></i> @lang('content.Add to Cart')
                        </button>
                    </div>
                </div>
            </div>
        <div class="modal fade product_view" id="quick_view{{ $product->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a href="#" data-dismiss="modal" class="class pull-right">
                            <span class="fa fa-remove"></span>
                        </a>
                        <h3 class="modal-title product-name">{{ $product->product_name }}</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!--  Product Details -->
                            <div class="product product-details clearfix">
                                <div class="col-md-6">
                                    <div id="product-main-view">
                                        <div class="product-view">
                                            <img src="{{ $product->image->main_name ? asset('img/products/'. $product->image->main_name) : 'http://via.placeholder.com/1200x1200?text=ProductPhoto' }}"
                                                 alt="{{ $product->product_name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="product-body">
                                        <div class="product-label">
                                            <span>@lang('content.New')</span>
                                            @if($product->discount>0)
                                                <span class="sale">-{{ $product->discount }}%</span>
                                            @endif
                                        </div>
                                        <br>
                                        <h3 class="product-price">{{ $product->sale_price }}‎₼
                                            @if($product->discount>0)
                                                <del class="product-old-price">{{ $product->retail_price }}‎₼
                                                </del>
                                            @endif
                                        </h3>
                                        <p>
                                            <strong>@lang('content.Availability'):</strong>
                                            {{ $product->stok_piece>0 ? __('content.In Stock') : __('content.Out Stock') }}
                                        </p>
                                        <p>
                                            <strong>@lang('content.Brand'):</strong>
                                            @foreach($product->brands as $brand)
                                                {{ $brand->name }}
                                            @endforeach
                                        </p>
                                        <p>{{ $product->description }}</p>
                                        <div class="product-btns">
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                            <button type="submit" class="primary-btn add-to-cart" id="{{ $product->id }}">
                                                <i class="fa fa-shopping-cart"></i> @lang('content.Add to Cart')
                                            </button>
                                            <div class="pull-right">
                                                <button class="main-btn icon-btn add-wish-list" data-id="{{ $product->id }}"><i class="fa fa-heart"></i></button>
                                                <button class="main-btn icon-btn add-to-compare" data-id="{{ $product->id }}"><i class="fa fa-exchange"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Product Details -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
        
</div>
@else
    <h3 class="text-center">@lang('content.There is no any product')</h3>
@endif