<?php


Route::namespace('Customer')->group(function () {
    Route::get('/', 'HomepageController@index')->name('homepage');
    Route::get('/products', 'HomepageController@products')->name('homepage.products');
    Route::get('/insert_ratings', 'HomepageController@insert_ratings')->name('homepage.insert_ratings');
    Route::get('/category/{slug_category_name}', 'CategoryController@index')->name('category');
    Route::get('/category_products', 'CategoryController@products')->name('category.products');
    Route::get('/category_price_filter', 'CategoryController@price_filter')->name('category.price_filter');
    Route::get('/category_brand_filter', 'CategoryController@brand_filter')->name('category.brand_filter');
    Route::get('/category_size_filter', 'CategoryController@size_filter')->name('category.size_filter');
    Route::get('/category_color_filter', 'CategoryController@color_filter')->name('category.color_filter');
    Route::get('/category_sorting', 'CategoryController@category_sorting')->name('category.category_sorting');
    Route::get('/product/{slug_product_name}', 'ProductController@index')->name('product');
    Route::post('/search', 'ProductController@search')->name('search_product');
    Route::get('/search', 'ProductController@search')->name('search_product');
    Route::get('/newproducts', 'ProductController@new_products')->name('new_products');
    Route::get('/discounted', 'ProductController@discounted')->name('discounted');
    Route::get('/contact', 'HomepageController@contact')->name('contact');
    Route::post('/contact_send', 'HomepageController@send')->name('contact.send');
    Route::get('/add_wish_list', 'WishlistController@add_wish_list')->name('add_wish_list');
    Route::get('/brands/{brand_name}', 'BrandsController@index')->name('brands');
    Route::get('/brands_roducts', 'BrandsController@brands')->name('brands.brands_roducts');
    Route::get('/brand_sorting', 'BrandsController@brand_sorting')->name('brands.brand_sorting');
    Route::get('/brand_size_filter', 'BrandsController@size_filter')->name('brands.size_filter');
    Route::get('/brand_color_filter', 'BrandsController@color_filter')->name('brands.color_filter');
    Route::get('/brand_price_filter', 'BrandsController@price_filter')->name('brands.price_filter');
    Route::post('/review', 'ProductController@review')->name('product.review');
    Route::post('/reviews', 'ProductController@reviews')->name('product.reviews');
    Route::get('/about', 'HomepageController@about')->name('about');
    Route::get('/shipping_return', 'HomepageController@shipping_return')->name('shipping_return');
    Route::get('/invoice', 'HomepageController@invoice')->name('invoice');
    
    Route::prefix('compare')->group(function () {
        Route::get('/', 'ProductController@compare')->name('compare');
        Route::get('/add_to_compare', 'ProductController@add_to_compare')->name('compare.add_to_compare');
        Route::get('/remove_from_compare', 'ProductController@remove_from_compare')->name('compare.remove_from_compare');
        Route::get('/view', 'ProductController@view_compare')->name('compare.view_compare');
    });

    Route::prefix('cart')->group(function () {
        Route::get('/', 'CartController@index')->name('cart');
        Route::get('/my_cart', 'CartController@my_cart')->name('cart.my_cart');
        Route::get('/add_to_cart', 'CartController@add_to_cart')->name('cart.add_to_cart');
        Route::get('/update_cart', 'CartController@update_cart')->name('cart.update_cart');
        Route::get('/delete', 'CartController@delete')->name('cart.delete');
        Route::get('/destroy', 'CartController@destroy')->name('cart.destroy');
        
    });
    

    Route::middleware(['auth'])->group(function () {
        Route::get('/payment', 'PaymentController@index')->name('payment');
        Route::post('/payment', 'PaymentController@pay')->name('pay');
        Route::get('/orders', 'OrderController@index')->name('orders');
        Route::get('/orders/{id}', 'OrderController@detail')->name('order');
        Route::post('/user/sign-out', 'UserController@sign_out')->name('user.sign_out');
        Route::get('/my_wish_list', 'WishlistController@index')->name('my_wish_list');
        Route::get('/view_my_wish_list', 'WishlistController@view_my_wish_list')->name('view_my_wish_list');
        Route::get('/remove_wish_list', 'WishlistController@remove_wish_list')->name('remove_wish_list');
        Route::get('/account', 'UserController@my_account')->name('user.my_account');
        Route::get('/membership', 'UserController@membership')->name('user.membership');
        Route::post('/form_info', 'UserController@form_info')->name('user.form_info');
        Route::post('/form_detail', 'UserController@form_detail')->name('user.form_detail');
        Route::post('/form_password', 'UserController@form_password')->name('user.form_password');
    });
    
    Route::get('user/activate/{activation_key}', 'UserController@activate')->name('user.activate');
    Route::middleware(['guest'])->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/sign-up', 'UserController@sign_up_form')->name('user.sign_up');
            Route::post('/sign-up', 'UserController@sign_up');
            Route::get('/sign-in', 'UserController@sign_in_form')->name('user.sign_in');
            Route::post('/sign-in', 'UserController@sign_in');
            Route::get('/reset-password', 'UserController@reset_password_form');
            Route::post('/reset-password', 'UserController@reset_password')->name('user.reset_password');
            Route::get('/reset_password/{email}/{token}', 'UserController@resetPassword')->name('user.resetPassword');
            Route::post('/change_password', 'UserController@change_password')->name('user.change_password');
        });
    });

    Route::post('/payment/return/{orderid}', 'PaymentController@paymentPageReturn')->name('payment.return');
});

Route::namespace('Manage')->prefix('manage')->group(function () {
    Route::redirect('/', '/manage/homepage');

    Route::match(['get', 'post'], '/login', 'AdminController@login')->name('manage.login');
    Route::get('/logout', 'AdminController@logout')->name('manage.logout');
    Route::match(['get', 'post'], '/forgot-password', 'AdminController@forgot')->name('manage.forgot.password');
    Route::get('/recovery-password/{token}/{email}', 'AdminController@recovery')->name('manage.recovery.password');
    Route::post('/change-password', 'AdminController@change')->name('manage.change.password');
    Route::group(['middleware' => 'manage'], function () {
		
        Route::get('/homepage', 'HomepageController@index')->name('manage.homepage');

        Route::group(['prefix' => 'admin'], function () {
            Route::get('/', 'AdminController@index')->name('manage.admin');
            Route::get('/index_data', 'AdminController@index_data')->name('manage.admin.index_data');
            Route::post('/post_data', 'AdminController@post_data')->name('manage.admin.post_data');
            Route::get('/fetch_data', 'AdminController@fetch_data')->name('manage.admin.fetch_data');
            Route::get('/delete_data', 'AdminController@delete_data')->name('manage.admin.delete_data');
            Route::get('/mass_remove', 'AdminController@mass_remove')->name('manage.admin.mass_remove');
            Route::get('/new', 'AdminController@form')->name('manage.admin.new');
            Route::get('/edit/{id}', 'AdminController@form')->name('manage.admin.edit');
            Route::post('/save/{id?}', 'AdminController@save')->name('manage.admin.save');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UserController@index')->name('manage.user');
            Route::get('/index_data', 'UserController@index_data')->name('manage.user.index_data');
            Route::post('/post_data', 'UserController@post_data')->name('manage.user.post_data');
            Route::get('/fetch_data', 'UserController@fetch_data')->name('manage.user.fetch_data');
            Route::get('/delete_data', 'UserController@delete_data')->name('manage.user.delete_data');
            Route::get('/mass_remove', 'UserController@mass_remove')->name('manage.user.mass_remove');
            Route::get('/new', 'UserController@form')->name('manage.user.new');
            Route::get('/edit/{id}', 'UserController@form')->name('manage.user.edit');
            Route::post('/save/{id?}', 'UserController@save')->name('manage.user.save');
        });

        Route::group(['prefix' => 'category'], function () {
            Route::get('/', 'CategoryController@index')->name('manage.category');
            Route::get('/index_data', 'CategoryController@index_data')->name('manage.category.index_data');
            Route::post('/post_data', 'CategoryController@post_data')->name('manage.category.post_data');
            Route::get('/fetch_data', 'CategoryController@fetch_data')->name('manage.category.fetch_data');
            Route::get('/delete_data', 'CategoryController@delete_data')->name('manage.category.delete_data');
            Route::get('/mass_remove', 'CategoryController@mass_remove')->name('manage.category.mass_remove');
        });

        Route::group(['prefix' => 'product'], function () {
            Route::get('/', 'ProductController@index')->name('manage.product');
            Route::get('/index_data', 'ProductController@index_data')->name('manage.product.index_data');
            Route::post('/post_data', 'ProductController@post_data')->name('manage.product.post_data');
            Route::get('/fetch_data', 'ProductController@fetch_data')->name('manage.product.fetch_data');
            Route::get('/delete_data', 'ProductController@delete_data')->name('manage.product.delete_data');
            Route::get('/mass_remove', 'ProductController@mass_remove')->name('manage.product.mass_remove');
            Route::get('/new', 'ProductController@form')->name('manage.product.new');
            Route::get('/edit/{id}', 'ProductController@form')->name('manage.product.edit');
            Route::get('/filter/{id}', 'ProductController@filter')->name('manage.product.filter');
            Route::get('/filter_data/{id}', 'ProductController@filter_data')->name('manage.product.filter_data');
            Route::post('/save/{id?}', 'ProductController@save')->name('manage.product.save');
            Route::post('/remove_image', 'ProductController@remove_image')->name('manage.product.remove_image');
            Route::post('/load_images', 'ProductController@load_images')->name('manage.product.load_images');
            Route::get('/categories', 'ProductController@categories')->name('manage.product.categories');
        });
        Route::group(['prefix' => 'color'], function () {
            Route::get('/', 'ColorController@index')->name('manage.color');
            Route::get('/index_data', 'ColorController@index_data')->name('manage.color.index_data');
            Route::post('/post_data', 'ColorController@post_data')->name('manage.color.post_data');
            Route::get('/fetch_data', 'ColorController@fetch_data')->name('manage.color.fetch_data');
            Route::get('/delete_data', 'ColorController@delete_data')->name('manage.color.delete_data');
            Route::get('/mass_remove', 'ColorController@mass_remove')->name('manage.color.mass_remove');
        });
        Route::group(['prefix' => 'size'], function () {
            Route::get('/', 'SizeController@index')->name('manage.size');
            Route::get('/index_data', 'SizeController@index_data')->name('manage.size.index_data');
            Route::post('/post_data', 'SizeController@post_data')->name('manage.size.post_data');
            Route::get('/fetch_data', 'SizeController@fetch_data')->name('manage.size.fetch_data');
            Route::get('/delete_data', 'SizeController@delete_data')->name('manage.size.delete_data');
            Route::get('/mass_remove', 'SizeController@mass_remove')->name('manage.size.mass_remove');
        });
        Route::group(['prefix' => 'slider'], function () {
            Route::get('/', 'SlideshowController@index')->name('manage.slider');
            Route::post('/reorder', 'SlideshowController@reorder')->name('manage.slider.reorder');
            Route::get('/index_data', 'SlideshowController@index_data')->name('manage.slider.index_data');
            Route::get('/delete_data', 'SlideshowController@delete_data')->name('manage.slider.delete_data');
            Route::get('/mass_remove', 'SlideshowController@mass_remove')->name('manage.slider.mass_remove');
            Route::get('/new', 'SlideshowController@form')->name('manage.slider.new');
            Route::get('/edit/{id}', 'SlideshowController@form')->name('manage.slider.edit');
            Route::post('/save', 'SlideshowController@save')->name('manage.slider.save');
        });
        Route::group(['prefix' => 'banner'], function () {
            Route::get('/', 'BannerController@index')->name('manage.banner');
            Route::post('/reorder', 'BannerController@reorder')->name('manage.banner.reorder');
            Route::get('/index_data', 'BannerController@index_data')->name('manage.banner.index_data');
            Route::get('/delete_data', 'BannerController@delete_data')->name('manage.banner.delete_data');
            Route::get('/mass_remove', 'BannerController@mass_remove')->name('manage.banner.mass_remove');
            Route::get('/new', 'BannerController@form')->name('manage.banner.new');
            Route::get('/edit/{id}', 'BannerController@form')->name('manage.banner.edit');
            Route::post('/save/{id?}', 'BannerController@save')->name('manage.banner.save');
        });
        Route::group(['prefix' => 'review'], function () {
            Route::get('/', 'ReviewController@index')->name('manage.review');
            Route::get('/index_data', 'ReviewController@index_data')->name('manage.review.index_data');
            Route::post('/view', 'ReviewController@view')->name('manage.review.view');
            Route::get('/delete_data', 'ReviewController@delete_data')->name('manage.review.delete_data');
            Route::get('/mass_remove', 'ReviewController@mass_remove')->name('manage.review.mass_remove');
            
        });
        Route::group(['prefix' => 'envelope'], function () {
            Route::get('/', 'EnvelopeController@index')->name('manage.envelope');
            Route::get('/index_data', 'EnvelopeController@index_data')->name('manage.envelope.index_data');
            Route::post('/feedback', 'EnvelopeController@feedback')->name('manage.envelope.feedback');
            Route::post('/view', 'EnvelopeController@view')->name('manage.envelope.view');

        });

        Route::group(['prefix' => 'info'], function () {
            Route::get('/', 'InfoController@index')->name('manage.info');
            Route::post('/save', 'InfoController@save')->name('manage.info.save');
            
        });
        Route::group(['prefix' => 'shipping_return'], function () {
            Route::get('/', 'ShippingReturnController@index')->name('manage.shipping_return');
            Route::post('/save', 'ShippingReturnController@save')->name('manage.shipping_return.save');
            
        });
        Route::group(['prefix' => 'about'], function () {
            Route::get('/', 'AboutController@index')->name('manage.about');
            Route::post('/save', 'AboutController@save')->name('manage.about.save');
            
        });

        Route::group(['prefix' => 'sell'], function () {
            Route::get('/', 'SellController@index')->name('manage.sell');
            Route::post('/products', 'SellController@products')->name('manage.sell.products');
            Route::post('/search', 'SellController@search')->name('manage.sell.search');
            Route::post('/sale_list', 'SellController@sale_list')->name('manage.sell.sale_list');
            Route::post('/manual_cart_remove', 'SellController@manual_cart_remove')->name('manage.sell.manual_cart_remove');
            Route::post('/trash_cart', 'SellController@trash_cart')->name('manage.sell.trash_cart');
        });
        

        Route::group(['prefix' => 'brand'], function () {
            Route::get('/', 'BrandController@index')->name('manage.brand');
            Route::get('/index_data', 'BrandController@index_data')->name('manage.brand.index_data');
            Route::post('/post_data', 'BrandController@post_data')->name('manage.brand.post_data');
            Route::get('/fetch_data', 'BrandController@fetch_data')->name('manage.brand.fetch_data');
            Route::get('/delete_data', 'BrandController@delete_data')->name('manage.brand.delete_data');
            Route::get('/mass_remove', 'BrandController@mass_remove')->name('manage.brand.mass_remove');
        });

        Route::group(['prefix' => 'tag'], function () {
            Route::get('/', 'TagController@index')->name('manage.tag');
            Route::get('/index_data', 'TagController@index_data')->name('manage.tag.index_data');
            Route::post('/post_data', 'TagController@post_data')->name('manage.tag.post_data');
            Route::get('/fetch_data', 'TagController@fetch_data')->name('manage.tag.fetch_data');
            Route::get('/delete_data', 'TagController@delete_data')->name('manage.tag.delete_data');
            Route::get('/mass_remove', 'TagController@mass_remove')->name('manage.tag.mass_remove');
        });

        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', 'SupplierController@index')->name('manage.supplier');
            Route::get('/index_data', 'SupplierController@index_data')->name('manage.supplier.index_data');
            Route::post('/post_data', 'SupplierController@post_data')->name('manage.supplier.post_data');
            Route::get('/new', 'SupplierController@form')->name('manage.supplier.new');
            Route::get('/edit/{id}', 'SupplierController@form')->name('manage.supplier.edit');
            Route::post('/save/{id?}', 'SupplierController@save')->name('manage.supplier.save');
            Route::get('/delete_data', 'SupplierController@delete_data')->name('manage.supplier.delete_data');
            Route::get('/mass_remove', 'SupplierController@mass_remove')->name('manage.supplier.mass_remove');
        });

        Route::group(['prefix' => 'customer'], function () {
            Route::get('/', 'CustomerController@index')->name('manage.customer');
            Route::get('/index_data', 'CustomerController@index_data')->name('manage.customer.index_data');
            Route::post('/post_data', 'CustomerController@post_data')->name('manage.customer.post_data');
            Route::get('/new', 'CustomerController@form')->name('manage.customer.new');
            Route::get('/edit/{id}', 'CustomerController@form')->name('manage.customer.edit');
            Route::post('/save/{id?}', 'CustomerController@save')->name('manage.customer.save');
            Route::get('/delete_data', 'CustomerController@delete_data')->name('manage.customer.delete_data');
            Route::get('/mass_remove', 'CustomerController@mass_remove')->name('manage.customer.mass_remove');
        });

        Route::group(['prefix' => 'order'], function () {
            Route::get('/', 'OrderController@index')->name('manage.order');
            Route::get('/index_data', 'OrderController@index_data')->name('manage.order.index_data');
            Route::get('/new', 'OrderController@form')->name('manage.order.new');
            Route::get('/edit/{id}', 'OrderController@form')->name('manage.order.edit');
            Route::post('/save/{id?}', 'OrderController@save')->name('manage.order.save');
            Route::get('/delete/{id}', 'OrderController@delete')->name('manage.order.delete');
            Route::get('/invoice_view', 'InvoiceController@index')->name('manage.order.invoice_view');
        });
    });
    
});
Route::namespace('Usermanage')->prefix('usermanage')->group(function () {
    Route::redirect('/', '/usermanage/homepage');

    Route::match(['get', 'post'], '/login', 'AdminController@login')->name('usermanage.login');
    Route::get('/logout', 'AdminController@logout')->name('usermanage.logout');
    Route::group(['middleware' => 'customer'], function () {
        Route::get('/homepage', 'HomepageController@index')->name('usermanage.homepage');

            Route::group(['prefix' => 'admin'], function () {
                Route::get('/', 'AdminController@index')->name('usermanage.admin');
                Route::get('/index_data', 'AdminController@index_data')->name('usermanage.admin.index_data');
                Route::post('/post_data', 'AdminController@post_data')->name('usermanage.admin.post_data');
                Route::get('/fetch_data', 'AdminController@fetch_data')->name('usermanage.admin.fetch_data');
                Route::get('/delete_data', 'AdminController@delete_data')->name('usermanage.admin.delete_data');
                Route::get('/mass_remove', 'AdminController@mass_remove')->name('manage.usermanage.admin.mass_remove');
                // Route::get('/new', 'AdminController@form')->name('manage.admin.new');
                // Route::get('/edit/{id}', 'AdminController@form')->name('manage.admin.edit');
                // Route::post('/save/{id?}', 'AdminController@save')->name('manage.admin.save');
            });

            Route::group(['prefix' => 'user'], function () {
                Route::get('/', 'UserController@index')->name('usermanage.user');
                Route::get('/index_data', 'UserController@index_data')->name('usermanage.user.index_data');
                Route::post('/post_data', 'UserController@post_data')->name('usermanage.user.post_data');
                Route::get('/fetch_data', 'UserController@fetch_data')->name('usermanage.user.fetch_data');
                Route::get('/delete_data', 'UserController@delete_data')->name('usermanage.user.delete_data');
                Route::get('/mass_remove', 'UserController@mass_remove')->name('usermanage.user.mass_remove');
                Route::get('/new', 'UserController@form')->name('usermanage.user.new');
                Route::get('/edit/{id}', 'UserController@form')->name('usermanage.user.edit');
                Route::post('/save/{id?}', 'UserController@save')->name('usermanage.user.save');
            });

            Route::group(['prefix' => 'category'], function () {
                Route::get('/', 'CategoryController@index')->name('usermanage.category');
                Route::get('/index_data', 'CategoryController@index_data')->name('usermanage.category.index_data');
                Route::post('/post_data', 'CategoryController@post_data')->name('usermanage.category.post_data');
                Route::get('/fetch_data', 'CategoryController@fetch_data')->name('usermanage.category.fetch_data');
                Route::get('/delete_data', 'CategoryController@delete_data')->name('usermanage.category.delete_data');
                Route::get('/mass_remove', 'CategoryController@mass_remove')->name('usermanage.category.mass_remove');
            });

            Route::group(['prefix' => 'product'], function () {
                Route::get('/', 'ProductController@index')->name('usermanage.product');
                Route::get('/index_data', 'ProductController@index_data')->name('usermanage.product.index_data');
                Route::post('/post_data', 'ProductController@post_data')->name('usermanage.product.post_data');
                Route::get('/fetch_data', 'ProductController@fetch_data')->name('usermanage.product.fetch_data');
                Route::get('/delete_data', 'ProductController@delete_data')->name('usermanage.product.delete_data');
                Route::get('/mass_remove', 'ProductController@mass_remove')->name('usermanage.product.mass_remove');
                Route::get('/new', 'ProductController@form')->name('usermanage.product.new');
                Route::get('/edit/{id}', 'ProductController@form')->name('usermanage.product.edit');
                Route::get('/filter/{id}', 'ProductController@filter')->name('usermanage.product.filter');
                Route::get('/filter_data/{id}', 'ProductController@filter_data')->name('usermanage.product.filter_data');
                Route::post('/save/{id?}', 'ProductController@save')->name('usermanage.product.save');
                Route::post('/remove_image', 'ProductController@remove_image')->name('usermanage.product.remove_image');
                Route::post('/load_images', 'ProductController@load_images')->name('usermanage.product.load_images');
            });

            Route::group(['prefix' => 'sell'], function () {
                Route::get('/', 'SellController@index')->name('usermanage.sell');
                Route::post('/products', 'SellController@products')->name('usermanage.sell.products');
                Route::post('/search', 'SellController@search')->name('usermanage.sell.search');
                Route::post('/sale_list', 'SellController@sale_list')->name('usermanage.sell.sale_list');
                Route::post('/manual_cart_remove', 'SellController@manual_cart_remove')->name('usermanage.sell.manual_cart_remove');
                Route::post('/trash_cart', 'SellController@trash_cart')->name('usermanage.sell.trash_cart');
            });

            Route::group(['prefix' => 'brand'], function () {
                Route::get('/', 'BrandController@index')->name('usermanage.brand');
                Route::get('/index_data', 'BrandController@index_data')->name('usermanage.brand.index_data');
                Route::post('/post_data', 'BrandController@post_data')->name('usermanage.brand.post_data');
                Route::get('/fetch_data', 'BrandController@fetch_data')->name('usermanage.brand.fetch_data');
                Route::get('/delete_data', 'BrandController@delete_data')->name('usermanage.brand.delete_data');
                Route::get('/mass_remove', 'BrandController@mass_remove')->name('usermanage.brand.mass_remove');
            });

            Route::group(['prefix' => 'tag'], function () {
                Route::get('/', 'TagController@index')->name('usermanage.tag');
                Route::get('/index_data', 'TagController@index_data')->name('usermanage.tag.index_data');
                Route::post('/post_data', 'TagController@post_data')->name('usermanage.tag.post_data');
                Route::get('/fetch_data', 'TagController@fetch_data')->name('usermanage.tag.fetch_data');
                Route::get('/delete_data', 'TagController@delete_data')->name('usermanage.tag.delete_data');
                Route::get('/mass_remove', 'TagController@mass_remove')->name('usermanage.tag.mass_remove');
            });

            Route::group(['prefix' => 'supplier'], function () {
                Route::get('/', 'SupplierController@index')->name('usermanage.supplier');
                Route::get('/index_data', 'SupplierController@index_data')->name('usermanage.supplier.index_data');
                Route::post('/post_data', 'SupplierController@post_data')->name('usermanage.supplier.post_data');
                Route::get('/new', 'SupplierController@form')->name('usermanage.supplier.new');
                Route::get('/edit/{id}', 'SupplierController@form')->name('usermanage.supplier.edit');
                Route::post('/save/{id?}', 'SupplierController@save')->name('usermanage.supplier.save');
                Route::get('/delete_data', 'SupplierController@delete_data')->name('usermanage.supplier.delete_data');
                Route::get('/mass_remove', 'SupplierController@mass_remove')->name('usermanage.supplier.mass_remove');
            });

            Route::group(['prefix' => 'customer'], function () {
                Route::get('/', 'CustomerController@index')->name('usermanage.customer');
                Route::get('/index_data', 'CustomerController@index_data')->name('usermanage.customer.index_data');
                Route::post('/post_data', 'CustomerController@post_data')->name('usermanage.customer.post_data');
                Route::get('/new', 'CustomerController@form')->name('usermanage.customer.new');
                Route::get('/edit/{id}', 'CustomerController@form')->name('usermanage.customer.edit');
                Route::post('/save/{id?}', 'CustomerController@save')->name('usermanage.customer.save');
                Route::get('/delete_data', 'CustomerController@delete_data')->name('usermanage.customer.delete_data');
                Route::get('/mass_remove', 'CustomerController@mass_remove')->name('usermanage.customer.mass_remove');
            });

            Route::group(['prefix' => 'order'], function () {
                Route::match(['get', 'post'], '/', 'OrderController@index')->name('usermanage.order');
                Route::get('/new', 'OrderController@form')->name('usermanage.order.new');
                Route::get('/edit/{id}', 'OrderController@form')->name('usermanage.order.edit');
                Route::post('/save/{id?}', 'OrderController@save')->name('usermanage.order.save');
                Route::get('/delete/{id}', 'OrderController@delete')->name('usermanage.order.delete');
            });

            Route::post("ckeditor_slider_upload", 'CommonControllers@ckEditorSliderUpload')->name("ckeditorSliderUpload");
            Route::post("ckeditor_products_upload", 'CommonControllers@ckEditorProductUpload')->name("ckeditorProductUpload");
    
    });
});