<?php

namespace App\Http\Controllers\Api\delivery_service_provider;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Traits\Responses;
use Illuminate\Http\Request;


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


                foreach( $order->sizes()->withTrashed()
                ->join('colors','colors.id','sizes.color_id')
                ->join('products','products.id','colors.product_id')
                ->withTrashed()->where('products.user_id',$vendor->id)->get() as $size){

                    $amount=$order->colors()->where('color_id',$size->color->id)->first()->pivot->amount;
                    $tax=$size->color()->withTrashed()->first()->product()->withTrashed()->first()->taxes()->withTrashed()->sum('tax');
                    $products[]=[
                        'size' => $size->pivot->size,
                        'quantity' => $size->pivot->quantity,
                        'image' => $size->color()->withTrashed()->first()->images()->first()->name,
                        'color' => $size->color()->withTrashed()->first()->color,
                        'name' => app()->getLocale()== 'ar' ? $size->color()->withTrashed()->first()->product()->withTrashed()->first()->name_ar:$size->color()->withTrashed()->first()->product()->withTrashed()->first()->name_en,
                        'price' => $amount + ($amount*($tax/100)) ,
                    ];
                }

                $data[]=
                [   'vendor' =>
                        [
                            'store_name' => $vendor->store_name,
                            'location' => $vendor->geoLocation,
                            'phone' => $vendor->phone,
                            'taxes' => $vendor->pivot->taxes,
                            'subtotal' => $vendor->pivot->subtotal,
                            'total_amount' => $vendor->pivot->total_amount,
                            'products' =>$products
                        ],
                ];

                $products=[];
            }

            return $this->success($data,'',200);


        }else{
            return $this->error(__('text.Not Found'),404);
        }
    }


}
