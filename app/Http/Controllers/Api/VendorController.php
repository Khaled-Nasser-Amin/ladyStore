<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\VendorCollection;
use App\Models\User;
use App\Traits\Responses;
use Illuminate\Http\Request;


class VendorController extends Controller
{
    use Responses;


    public function all_vendors()
    {
        $vendors=User::all();
        return $this->success(VendorCollection::collection($vendors));
    }


    public function vendor_products(Request $request)
    {
        app()->setlocale($request->lang);
        $vendor=User::find($request->vendor_id);

        if($vendor){
            $products=$vendor->products;
            $categories=$products->pluck('category');
            foreach($categories as $category){
                $data[]=
                [
                    'category_name' => app()->getLocale() == 'ar' ? $category->name_ar:$category->name_en,
                    'category_id' => $category->id,
                    'products' => ProductCollection::collection($products->where('category_id',$category->id)),
                ];
            }

            return $this->success($data);

        }else{
            return $this->error(__('text.Not Found'),404);
        }
    }





}
