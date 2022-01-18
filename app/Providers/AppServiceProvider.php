<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Info;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\ShippingReturn;
use App\Models\Slider;
use App\Models\Supplier;
use App\Models\Tag;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer(['manage.*'], function ($view) {
            $endTime = now()->addMinutes(1);
            $manage = (Auth::guard('manage')->check()) ? Auth::guard('manage')->user()->is_manage : 0;
            $statistics = Cache::remember('statistics', $endTime, function () {
                return [
                    'total_order' => Order::count(),
                    'total_payment_approved' => Order::where('status', 'Payment approved')->count(),
                    'total_order_completed' => Order::where('status', 'Order Completed')->count(),
                    'total_order_pending' => Order::where('status', 'Pending')->count(),
                    'total_order_cargoed' => Order::where('status', 'Cargoed')->count(),
                    'total_order_yohbr' => Order::where('status', 'Your order has been received')->count(),
                    'total_product' => Product::count(),
                    'total_brand' => Brand::count(),
                    'total_supplier' => Supplier::count(),
                    'total_customer' => Customer::count(),
                    'total_tag' => Tag::count(),
                    'total_category' => Category::count(),
                    'total_user' => User::count(),
                    'total_admin' => Admin::count(),
                    'total_slider' => Slider::count(),
                    'total_banner' => Banner::count(),
                    'total_reviews' => Review::count(),
                    'total_messages' => Contact::count(),
                ];
            });

            $view->with('statistics', $statistics)->with('manage', $manage);
        });
        
        View::composer('*', function ($view) {
            $website_info = Info::find(1);
            $about = About::find(1);
            $shippingreturn = ShippingReturn::find(1);
            return $view->with([
                'website_info' => $website_info, 
                'about' => $about,
                'shippingreturn' => $shippingreturn,
            ]);
        });

        if (Schema::hasTable('category')) {
            $global_categories_headermenu = Category::where('slug', 'kisi-geyimleri')->orWhere('slug', 'qadin-geyimleri')->get();
            $global_categories_sidemenu = Category::all();
            $all_global_categories = Category::all();
            View::share([
                'global_categories_sidemenu' => $global_categories_sidemenu,
                'global_categories_headermenu' => $global_categories_headermenu,
                'all_global_categories' => $all_global_categories,
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
