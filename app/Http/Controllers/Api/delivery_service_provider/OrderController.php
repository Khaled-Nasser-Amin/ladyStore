<?php

namespace App\Http\Controllers\Api\delivery_service_provider;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Resources\OrderResource;
use App\Mail\EmptyStockSize;
use App\Mail\OrderCard;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use App\Traits\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\returnSelf;

class OrderController extends Controller
{
    use Responses;

    public function all_orders(Request $request)
    {
        $user=$request->user();
        return $this->success(OrderResource::collection($user->orders),'',200);
    }

    public function order_details(Request $request)
    {
        app()->setlocale($request->lang);
        $user=$request->user();
        $order=Order::find($request->order_id);

        if($order && $order->delivery_service_provider_id == $user->id){
            foreach($order->vendors()->withTrashed()->get() as $vendor){

                return $order->vendors()->withTrashed()->get()->colors()->withTrashed()->where('users.id',$vendor->id)->get();



                // $data[]=
                // [   'vendor' =>
                //         [
                //             'store_name' => $vendor->store_name,
                //             'location' => $vendor->geoLocation,
                //             'phone' => $vendor->phone,
                //             'taxes' => $vendor->pivot->taxes,
                //             'subtotal' => $vendor->pivot->subtotal,
                //             'total_amount' => $vendor->pivot->total_amount,

                //             'products' =>[]
                //         ],
                // ];
            }

            return $this->success($data,'',200);


        }else{
            return $this->error(__('text.Not Found'),404);
        }
    }


    protected function products($order){
        foreach ( $order->colors()->withTrashed()
        ->join('users','users.id','colors.product_id')
                 ->withTrashed()->where('products.user_id',auth()->user()->id)
        ->get() as $row){

        }
    }


}
