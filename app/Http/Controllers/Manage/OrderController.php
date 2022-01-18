<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        // if (request()->filled('wanted')) {
        //     request()->flash();
        //     $wanted = request('wanted');
        //     $list = Order::with('cart.user')->where('name', 'like', "%$wanted%")
        //         ->orWhere('id', 'like', "%$wanted%")
        //         ->orderByDesc('created_at')
        //         ->paginate(8)
        //         ->appends('wanted', $wanted);
        // } else {
        //     request()->flush();
        //     $list = Order::with('cart.user')
        //         ->orderByDesc('created_at')
        //         ->paginate(8);
        // }
        // return view('manage.pages.order.index', compact('list'));
        return view('manage.pages.order.index');
    }
    public function index_data()
    {
        $rows = Order::select(['order.*', DB::raw("CONCAT(order.first_name,' ',order.last_name) as name")]);
        return DataTables::eloquent($rows)
            ->filterColumn('name', function ($query, $keyword) {
                $sql = "CONCAT(order.first_name,' ',order.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $sql = "CONCAT(order.first_name,' ',order.last_name,' ',order.status)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('SP', function ($row) {
                return 'SP-' . $row->id;
                
            })
            ->addColumn('action', function ($row) {
                return '<div>
                        <a href="' . route('manage.order.edit', $row->id) .'" class="btn btn-xs btn-success" data-id="' . $row->id .'">' . __('admin.Edit') . '
                        <span class="fa fa-pencil"></span></a>
                        <a href="'.route('manage.order.delete', $row->id) . '" class="btn btn-xs btn-danger"  id="' . $row->id . '"> <i class="fa fa-remove"></i> ' . __('admin.Delete') . '</a>
                        </div>';
                
            })
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" name="checkbox[]" id="checkbox" class="checkbox" value="{{$id}}" />';
            })
            ->rawColumns(['checkbox', 'action', 'SP'])
            ->toJson();
    }

    public function form($id = 0)
    {
        if ($id > 0) {
            $entry = Order::with('cart.cart_products.product')->find($id);
        }

        return view('manage.pages.order.form', compact('entry'));
    }

    public function save($id = 0)
    {

        $this->validate(request(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'status' => 'required',
        ]);
        $cart_id = request('cart_id');
        $user_id = Cart::select('user_id')->where('id', $cart_id)->first();
        $user_id = $user_id->user_id;
        $user = User::where('id', $user_id)->first();
        
        $data = request()->only('first_name', 'last_name', 'address', 'phone', 'mobile', 'status');
        if ($id > 0) {
            $entry = Order::where('id', $id)->firstOrFail();
            $entry->update($data);
        }
        $order = Order::where('id', $id)->first();
        Mail::to($user->email)->send(new OrderStatus($order));
        return redirect()
            ->route('manage.order.edit', $entry->id)
            ->with('message_type', 'success')
            ->with('message', __('admin.Updated'));
    }

    public function delete($id)
    {
        Order::destroy($id);

        return redirect()
            ->route('manage.order')
            ->with('message_type', 'success')
            ->with('message', __('admin.The order deleted'));
    }

    public function invoice_view(){
        $order = Order::with('cart.cart_products.product')->find(request('id'));
        $user = User::where('id', $order->cart->user_id)->first();
        $data =[
            'total_amount' => $order->order_amount,
            'payment_status' => $order->status,
            'order_date' => $order->created_at,
            'payment_date' => '',
            'client_firstname' => $order->first_name,
            'client_lastname' => $order->last_name,
            'client_email' => $user->email,
            'client_tel' => $order->mobile,
            'client_address' => $order->address,
            'discount' => '',
            'order_items' => $order->cart->cart_products,
        ];

        // $pdf = PDF::loadView('common.invoices.default',$data);
        // return $pdf->download('invoice.pdf');
        $data = view('common.invoices.default', $data);
        return $data;
    }
}
