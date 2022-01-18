<!-- FOOTER -->
<footer id="footer" class="section section-grey col-md-12">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <!-- footer logo -->
                    <div class="footer-logo">
                        <a class="logo" href="#">
                            <img src="{{ asset('img/' . old('logo', $website_info->logo)) }}" alt="">
                        </a>
                    </div>
                    <!-- /footer logo -->

                    <p>@lang('footer.Your Address')</p>

                    <!-- footer social -->
                    <ul class="footer-social">
                        <li><a href="{{ old('facebook', $website_info->facebook) }}"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="{{ old('twitter', $website_info->twitter) }}"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="{{ old('instagram', $website_info->instagram) }}"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="{{ old('youtube', $website_info->youtube) }}"><i class="fa fa-youtube"></i></a></li>
                        <li><a href="{{ old('pinterest', $website_info->pinterest) }}"><i class="fa fa-pinterest"></i></a></li>
                    </ul>
                    <!-- /footer social -->
                </div>
            </div>
            <!-- /footer widget -->

            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">@lang('footer.My Account')</h3>
                    <ul class="list-links">
                        <li><a href="/account">@lang('footer.My Account')</a></li>
                        <li><a href="/my_wish_list">@lang('footer.My Wishlist')</a></li>
                        <li><a href="/compare">@lang('footer.Compare')</a></li>
                        <li><a href="/cart">Checkout</a></li>
                        <li><a href="/user/sign-in">@lang('footer.Login')</a></li>
                    </ul>
                </div>
            </div>
            <!-- /footer widget -->

            <div class="clearfix visible-sm visible-xs"></div>

            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">@lang('footer.Customer Service')</h3>
                    <ul class="list-links">
                        <li><a href="/about">@lang('footer.About Us')</a></li>
                        <li><a href="/shipping_return">@lang('footer.Shipping & Return')</a></li>
                        <li><a href="/contact">@lang('header.Contact')</a></li>
                    </ul>
                </div>
            </div>
            <!-- /footer widget -->

            <!-- footer subscribe -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">@lang('footer.Stay Connected')</h3>
                    <p>@lang('footer.Subscribe to Our Newsletter')</p>
                    <form>
                        <div class="form-group">
                            <input class="input" placeholder="@lang('footer.Enter Email Address')">
                        </div>
                        <button class="primary-btn">@lang('footer.Join Newsletter')</button>
                    </form>
                </div>
            </div>
            <!-- /footer subscribe -->
        </div>
        <!-- /row -->
        <hr>
        <!-- row -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <!-- footer copyright -->
                <div class="footer-copyright">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                    @lang('footer.All rights reserved')
                    <p>Bu sayt <a href="https://www.inova.az">Inova.az</a>® Qabaqcıl E-Ticarət sistemləri ilə hazırlanmışdır.</p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
                <!-- /footer copyright -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</footer>
<!-- /FOOTER -->