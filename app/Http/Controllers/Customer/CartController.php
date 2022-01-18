<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart as CartModel;
use App\Models\CartProduct;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        return view('customer.pages.cart');
    }

    public function my_cart()
    {
        $output = '';
        if (count(Cart::content()) > 0) {
            $output .= '<div data-v-eb8115a6="" class="Cart-Wrapper">
			<div data-v-eb8115a6="" class="Wrapper">';
            $output .= '<div data-v-eb8115a6="" class="Cart">
            <div data-v-eb8115a6="" class="CartItems">
                <div class="CartItemSeller">
                    <div class="CartBox">';

            foreach (Cart::content() as $productCartItem) {
                $stok_piece = Product::select('stok_piece')->where('id', $productCartItem->id)->first();
                $output .= '<div class="CartBox-Content">
                <div class="CartItemSeller-Products">
                    <div class="CartProduct">
                        <div
                            class="CartProduct-Image"
                            style="background-image: url(\'';
                            
                $output .= $productCartItem->options->image ? asset('img/products/' . $productCartItem->options->image) : "http://via.placeholder.com/1200x1200?text=ProductPhoto";
                $output .=            '\')"></div>
                        <div
                            class="CartProduct-Descriptions"
                        >
                            <div class="Description">
                                <!---->
                                <div class="Title">
                                    <h2>
                                        <a
                                            href="' . route('product', $productCartItem->options->slug) . '"
                                            class=""
                                            >' . $productCartItem->name . '</a
                                        >
                                    </h2>
                                </div>
                                <div class="Price">
                                    <div class="MPPrice">
                                        <span
                                            class="MPPrice-OldPrice"
                                            style="
                                                font-size: 16px;
                                                color: rgb(
                                                    30,
                                                    36,
                                                    77
                                                );
                                            "
                                            >' . $productCartItem->price . '‎ ₼<!----></span
                                        ><!----><!---->
                                    </div>
                                    <!---->
                                </div>
                            </div>
                            <div class="Quantity"><div
                            data-v-49522158=""
                            class="ProductQuantity"
                        >
                            <button
                                data-v-49522158=""
                                type="button"
                                tabindex="-1"
                                class="ProductQuantity-Minus"
                            >
                                <i
                                    data-v-49522158=""
                                    class="fa fa-minus"
                                ></i></button
                            ><input
                                data-v-49522158=""
                                type="number"
                                min="1"
                                id="input"
                                name="piece"
                                max="' . $stok_piece->stok_piece .'"
                                value="' . $productCartItem->qty . '"
                                data-id="' . $productCartItem->rowId . '"
                                step="1"
                                autocomplete="off"
                                class="ProductQuantity-Input"
                            /><button
                                data-v-49522158=""
                                type="button"
                                tabindex="-1"
                                class="ProductQuantity-Plus"
                            >
                                <i
                                    data-v-49522158=""
                                    class="fa fa-plus"
                                ></i>
                            </button>
                        </div>
                            </div>
                            <button type="submit" id="' . $productCartItem->rowId . '" class="delete Remove"><i class="fa fa-close"></i></button>
                        </div>
                    </div>
                </div>
            </div>';
            }
            $output .= '<div class="CartBox-Footer">
            <div class="CartItemSeller-Total">
                <div class="right">
                    <!---->
                    <div>
                        <span>Ümumi qiymət:</span
                        ><span class="total"
                            >' . Cart::total() . ' ₼</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>';
$output .= '<a href="' . route('payment') . '"><button type="button" class="CheckoutOrderBtn">
' . __('content.Place Order') . '
</button></a>
</div>
<div data-v-eb8115a6="" class="CartSummary">
<div class="CartSummaryInfo">
<div class="CartBox">
    <div class="CartBox-Title">
        <div class="Title">Sifariş detalları</div>
    </div>
    <div class="CartBox-Content">
        <div class="Content">
            <div>
                <span
                    >' . __('content.SHIPPING') . '</span
                ><em>' . __('content.Free Shipping') . '</em>
            </div>
            <!---->
        </div>
    </div>
    <div class="CartBox-Footer">
        <div class="Footer">
            <div>
                <strong>Ümumi ödəniləcək:</strong
                ><strong>' . Cart::total() . ' ₼</strong>
            </div>
        </div>
    </div>
</div>
</div>
<a href="' . route('payment') . '"><button type="button" class="CheckoutOrderBtn">
' . __('content.Place Order') . '
</button></a>
</div>
</div>
</div>
</div>';
        } else {
            $output .= '<div data-v-59955730="" class="LayoutMP-Main"><div data-v-0faeac38="" data-v-59955730="" class="Wrapper">
                <div data-v-0faeac38="" class="EmptyCart"><i data-v-0faeac38="" class="fa fa-shopping-bag"></i>
                <span data-v-0faeac38="">Səbətinizdə heç bir məhsul yoxdur</span></div></div></div>';
        }

        return $output;
    }

    public function update_cart()
    {
        $piece = request()->get('piece');
        $rowID = request()->get('rowID');
        Cart::update($rowID, $piece);
        $cart_count = Cart::count();
        echo $cart_count;
    }

    public function add_to_cart()
    {
        $piece = request()->get('piece');
        $stok_count = request()->get('stok_count');
        $product = Product::find(request()->get('id'));
        if(!isset($piece) || $piece === ""){
            $piece = 1;
        }
        if(!isset($stok_count) || $stok_count === ""){
            $stok_count = 1;
        }
        if($stok_count > $product->stok_piece)
        {
            return false;
        }
        if($piece > $product->stok_piece){
            $piece = $product->stok_piece;
        }
        
        if($cart = session()->get('cart')){
            $count = count($cart['default']);
        }
        
        if(isset($count) && $count > 0){
            $cart_conent = $cart['default'];
            $qty = 0;
            foreach ($cart_conent as $key => $value) {
                if($value->id == $product->id){
                    $qty = $value->qty;
                    break;
                }
            }
            if($qty >= $product->stok_piece){
                return false;
            }
        }
        
        
        $cartItem = Cart::add($product->id, $product->product_name, $piece, $product->sale_price, ['slug' => $product->slug, 'discount' => $product->discount, 'image' => $product->image->main_name]);
        if (auth()->check()) {
            $active_cart_id = session('active_cart_id');
            if (!isset($active_cart_id)) {
                $active_cart = CartModel::create([
                    'user_id' => auth()->id()
                ]);
                $active_cart_id = $active_cart->id;
                session()->put('active_cart_id', $active_cart_id);
            }
            CartProduct::updateOrCreate(
                ['cart_id' => $active_cart_id, 'product_id' => $product->id],
                ['piece' => $cartItem->qty, 'amount' => $product->sale_price, 'status' => 'Pending']
            );
        }
        
        if (count(Cart::content()) > 0) {
            
            $output = '<div class="shopping-cart-list">';
            foreach (Cart::content() as $productCartItem) {
                $output .= '<div class="product product-widget">';
                $output .= '<div class="product-thumb">';
                $output .= '<img src="';
                $output .= $productCartItem->options->image ? asset('img/products/' . $productCartItem->options->image) : 'http://via.placeholder.com/1200x1200?text=ProductPhoto';
                $output .= '"> </div>';
                $output .= '<div class="product-body">
                                    <h3 class="product-price">' . $productCartItem->price . ' ₼
                                    <span class="qty"> x ' . $productCartItem->qty . '</span></h3>
                                    <h2 class="product-name">
                                    <a href="' . route('product', $productCartItem->options->slug) . '">
                                    ' . $productCartItem->name . '
                                    </a>
                                    </h2>
                                </div>
                            </div>';
            }
            $output .= '</div>
                        <div class="shopping-cart-btns">
                            <a href="' . route('cart') . '" class="main-btn btn-block text-center">' . __("header.View Cart") . '</a>
                            
                        </div>';

            $view_cart = '<div class="shopping-cart-btns">
                            <a href="' . route('cart') . '" class="main-btn btn-block text-center">' . __("header.View Cart") . '</a>
                            
                        </div>';
        }

        $cart_count = Cart::count();
        $cart_total = Cart::subTotal();

        $data = array(
            'output' => $output,
            'cart_count' => $cart_count,
            'cart_total' => $cart_total,
            'view_cart' => $view_cart
        );

        echo json_encode($data);

    }

    public function delete()
    {
        if (auth()->check()) {
            $active_cart_id = session('active_cart_id');
            $cartItem = Cart::get(request()->get('rowID'));
            CartProduct::where('cart_id', $active_cart_id)->where('product_id', $cartItem->id)->delete();
        }
        Cart::remove(request()->get('rowID'));
    }

    public function destroy()
    {
        if (auth()->check()) {
            $active_cart_id = session('active_cart_id');
            CartProduct::where('cart_id', $active_cart_id)->delete();
        }
        Cart::destroy();
    }

    public function update($rowid)
    {
        $validator = Validator::make(request()->all(), [
            'piece' => 'required|numeric|between:1,5'
        ]);

        if ($validator->fails()) {
            session()->flash('message_type', 'danger');
            session()->flash('message', __('content.The number must be between 1 and 10'));
            return response()->json(['success' => false]);
        }

        if (auth()->check()) {
            $active_cart_id = session('active_cart_id');
            $cartItem = Cart::get($rowid);
            if (request('piece') == 0) {
                CartProduct::where('cart_id', $active_cart_id)->where('product_id', $cartItem->id)->delete();
            } else {
                CartProduct::where('cart_id', $active_cart_id)->where('product_id', $cartItem->id)->
                update(['piece' => request('piece')]);
            }
        }

        Cart::update($rowid, request('piece'));
        session()->flash('message_type', 'success');
        session()->flash('message', __('content.Piece info updated'));
        return route('cart');
    }

}
