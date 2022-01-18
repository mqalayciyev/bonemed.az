<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Mail\UserRegistration;
use App\Models\Cart as CartModel;
use App\Models\CartProduct;
use App\Models\PasswordReset;
use App\Models\UserDetail;
use App\User;
use Carbon\Carbon;
use DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function sign_up_form()
    {
        return view('customer.pages.user.sign_up');
    }

    public function sign_up()
    {
        $this->validate(request(), [
            'first_name' => 'required|min:3|max:25',
            'last_name' => 'required|min:3|max:25',
            'email' => 'required|email|unique:user|min:5|max:40',
            'mobile' => 'required|min:9|max:30',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'mobile' => request('mobile'),
            'password' => Hash::make(request('password')),
            'activation_key' => Str::random(60),
            'is_active' => 0
        ]);

        Mail::to(request('email'))->send(new UserRegistration($user));
        auth()->login($user);

        return redirect()->route('homepage');
    }

    public function sign_in_form()
    {
        return view('customer.pages.user.sign_in');
    }

    public function sign_in()
    {
        $this->validate(request(), [
            'email' => 'required|email|min:5|max:40',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => request('email'),
            'password' => request('password'),
            'is_active' => 1
        ];
        if (auth()->attempt($credentials, request()->has('remember_me'))) {
            request()->session()->regenerate();
            $active_cart_id = CartModel::active_cart_id();
            if (is_null($active_cart_id)) {
                $active_cart = CartModel::create(['user_id' => auth()->id()]);
                $active_cart_id = $active_cart->id;
            }
            session()->put('active_cart_id', $active_cart_id);

            if (Cart::count() > 0) {
                foreach (Cart::content() as $cartItem) {

                    CartProduct::updateOrCreate(
                        ['cart_id' => $active_cart_id, 'product_id' => $cartItem->id],
                        ['piece' => $cartItem->qty, 'amount' => $cartItem->price, 'status' => 'Pending']
                    );
                }
            }

            Cart::destroy();
            $cartProducts = CartProduct::where('cart_id', $active_cart_id)->get();
            foreach ($cartProducts as $cartProduct) {
                Cart::add($cartProduct->product->id, $cartProduct->product->product_name, $cartProduct->piece, $cartProduct->amount, ['slug' => $cartProduct->product->slug, 'discount' => $cartProduct->product->discount, 'image' => $cartProduct->product->image->main_name]);
            }

            return redirect()->intended('/');
        } else {
            $errors = ['email' => __('content.Incorrect entry')];
            return back()->withErrors($errors);
        }
    }

    public function activate($activation_key)
    {
        $user = User::where('activation_key', $activation_key)->first();
        if (!is_null($user)) {
            $user->activation_key = null;
            $user->is_active = 1;
            $user->save();
            return redirect()->to('/')
                ->with('message', 'Your user registration has been activated')
                ->with('message_type', 'success');
        } else {
            return redirect()->to('/')
                ->with('message', 'Your user is already enabled')
                ->with('message_type', 'warning');
        }
    }
    public function my_account(){
        return view('customer.pages.user.my_account');
    }
    public function membership(){
        $user_detail = UserDetail::where('user_id', auth()->id())->first();
        return view('customer.pages.user.membership', [
            'user_detail' => $user_detail,
        ]);
    }
    public function form_info(){
        User::where('id', auth()->id())->update([
            'first_name' => request('first_name'),
            'last_name' => request('last_name'),
            'email' => request('email'),
            'mobile' => request('mobile'),
        ]);
        $user_detail = UserDetail::where('user_id', auth()->id())->first();
        if(isset($user_detail)){
            UserDetail::where('user_id', auth()->id())->update([
                'phone' => request('phone'),
            ]);
        }
        else{
            UserDetail::create([
                'user_id' => auth()->id(),
                'phone' => request('phone'),
            ]);
        }
        echo 'success';
    }
    public function form_detail(){
        $user_detail = UserDetail::where('user_id', auth()->id())->first();
        if(isset($user_detail)){
            UserDetail::where('user_id', auth()->id())->update([
                'country' => request('country'),
                'state' => request('state'),
                'city' => request('city'),
                'zip_code' => request('zip_code'),
                'address' => request('address'),
            ]);
        }
        else{
            UserDetail::create([
                'user_id' => auth()->id(),
                'country' => request('country'),
                'state' => request('state'),
                'city' => request('city'),
                'zip_code' => request('zip_code'),
                'address' => request('address'),
            ]);
        }
        echo 'success';
    }
    public function form_password(){
        
        $user = Auth::user();

        $this->validate(request(), [
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'old_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail("Movcud sifre duzgun deyil.");
                }
            }]
        ]);
        
        User::find(auth()->id())->update([
            'password'=> Hash::make(Input::get('password')),
        ]);
        echo 'success';
    }
    public function reset_password_form(){
        return view('customer.pages.user.reset_password');
    }
    public function reset_password(){
        $user = User::where('email', '=', request('email'))->first();
        $count =User::where('email', '=', request('email'))->count();
        //Check if the user exists
        if ($count < 1) {
            return redirect()->back()->withErrors(['email' => trans('İstifadəçi mövcud deyil')]);
        }

        //Create Password Reset Token
        $token = str_random(60);
        PasswordReset::insert([
            'email' =>request('email'),
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        $reset = ['link' => 'http://demo.ecommerce.inova.az/user/reset_password', 'token' => $token, 'email' => request('email')];
        Mail::to(request('email'))->send(new ResetPassword($reset));
        return redirect()->back()->with('message', trans('Sıfırlama linki elektron poçt ünvanınıza göndərildi.'));
    }
    public function resetPassword($email, $token)
    {
        $count = PasswordReset::where('email', $email)
            ->where('token', $token)
            ->where('deleted_at', NULL)
            ->count();
        if($count > 0){
            return view('customer.pages.user.change_password', [
                'email' => $email,
                'token' => $token
            ]);
        }
        else{
            return view('customer.pages.user.error_token');
        }
        

    }
    public function change_password(){
        $this->validate(request(), [
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);
        User::where('email', request('email'))->update([
            'password' => Hash::make(request('password')),
        ]);
        PasswordReset::where('email', request('email'))
            ->where('token', request('token'))
            ->delete();
        return redirect()->route('user.sign_in')->with('message', 'Şifrəniz dəyişdirildi.');
    }

    public function sign_out()
    {
        auth()->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect()->route('homepage');
    }
}
