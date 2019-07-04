<?php

namespace App\Http\Controllers\Api\Client;

use App\Offer;
use App\Order;
use App\Product;
use App\Restaurant;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function myNotifications(Request $request){
        $notifications = $request->user()->notifications()->with('order', 'order.client', 'order.restaurant', 'order.paymentMethod', 'order.client.district', 'order.restaurant.district')->latest()->paginate(20);
        return apiResponse(1, "success", $notifications);
    }

    public function contacts(Request $request){
        $validator = validator()->make($request->all(),[
            'body'=>'required',
            'type'=>'required|in:complaint,suggesstion,query',
        ]);
        if($validator->fails()){
            return apiResponse(0 , $validator->errors()->first(), $validator->errors());
        }
        $contacts = $request->user()->contacts()->create($request->all());
        return apiResponse(1, "success", $contacts);
    }

    public function reviews(Request $request){
        $validator = validator()->make($request->all(), [
           'rating'=>'required|in:1,2,3,4,5',
           'comment'=>'required',
           'restaurant_id'=>'required|exists:restaurants,id'
        ]);
        if($validator->fails()){
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::find($request->restaurant_id);
        $request->merge(['client_id'=>$request->user()->id]);
        $orderType = $request->user()->orders()->where('restaurant_id',$restaurant->id)->whereIn('state',['delivered','declined'])->count(); //??
        if($orderType == 0){
            return apiResponse(0, "Must make order first from restaurant");
        }

        $review = $restaurant->reviews()->create($request->all());
        return apiResponse(1, "success", $review->load('client','restaurant'));
    }

    public function filterRestaurant(Request $request){
        $restaurant = Restaurant::with('district')->where(function($query) use($request){
            if($request->has('district_id')){
                $query->where('district_id', $request->district_id);
            }
        })->latest()->paginate(10);
        return apiResponse(1, "success", $restaurant);
    }

    public function myOrders(Request $request){
        $orders = $request->user()->orders()->where(function($order) use($request){
            if($request->has('state') && $request->state=='current'){
                $order->where('state','=','pending');
            }elseif($request->has('state') && $request->state=='previous'){
                $order->where('state','!=','pending');
            }
        })->with('restaurant','products')->latest()->paginate(10);
        return apiResponse(1,"success",$orders);
    }

    public function showOrder(Request $request){
        $order = Order::with('restaurant','products')->find($request->order_id);
        if(!$order){
            return apiResponse(0, "No data");
        }
        return apiResponse(1, "success", $order);
    }

    public function newOrder(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'products' => 'required|array',
            'products.*' => 'required|exists:products,id',
            'quantity' => 'required|array',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'special_order'=>'array',
        ]);
        if ($validator->fails()) {
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::find($request->restaurant_id);
        if ($restaurant->availability == 'closed') {
            return apiResponse(0, "Closed");
        }
        $order = $request->user()->orders()->create([
            'restaurant_id'=>$request->restaurant_id,
            'payment_method_id'=>$request->payment_method_id,
            'notes'=>$request->notes,
        ]);
        $cost = 0;
        $delivery_fees = $restaurant->delivery_fees;
        $counter = 0;
        foreach ($request->products as $productId) {
            $product = Product::find($productId);
            $readyProduct = [
                $productId => [
                    'quantity' => $request->quantity[$counter],
                    'price' => $product->price,
                    'special_order' => $request->special_order[$counter],

                ],
            ];
            $order->products()->attach($readyProduct);
            $cost += ($product->price * $request->quantity[$counter]);
            $counter++;
        }
            if ($cost >= $restaurant->min_charge) {
                $total_price = $cost + $delivery_fees;
                $settings = Setting::find(1);
                $commission = ($settings->commission) * $cost;
                $net = $total_price - $commission;
                $update = $order->update([
                    'cost' => $cost,
                    'delivery_fees' => $delivery_fees,
                    'total_price' => $total_price,
                    'commission' => $commission,
                    'net' => $net,
                ]);
                $notification = $restaurant->notifications()->create([
                    'title' => 'You have a new order',
                    'body' => 'You have a new order from ' . $request->user()->name,
                    'order_id' => $order->id,
                ]);
                $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
                if (count($tokens)) {
                    public_path();
                    $title = $notification->title;
                    $body = $notification->body;
                    $data = [
                        'order_id' => $order->id,
                    ];
                    $send = notifyByFirebase($title, $body, $tokens, $data);
                    info("firebase result: " . $send);
                }
                $data = $order->fresh()->load('products', 'client');
                return apiResponse(1, "success", $data);
            }else {
                $order->products()->detach();
                $order->delete();
                return apiResponse(0, 'Order must not be less than ' . $restaurant->min_charge);
            }


    }



    public function deliverOrder(Request $request){
        $order = $request->user()->orders()->find($request->order_id);
        if(!$order){
            return apiResponse(0, "No data");
        }
        $order->update(['state'=>'delivered']);
        $restaurant = $order->restaurant;
        $notification = $restaurant->notifications()->create([
            'title'=>'Delivered',
            'body'=>'Order no.'.$order->id.' is delivered',
            'order_id'=>$request->order_id,
        ]);
        $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        if(count($tokens)){
            $title = $notification->title;
            $body = $notification->body;
            $data = ['order_id'=>$request->order_id];
            $send = notifyByFirebase($title, $body, $tokens, $data);
            info("notify by firebase:".$send);
        }
        return apiResponse(1, "Delivered");
    }



    public function declineOrder(Request $request){
        $order = $request->user()->orders()->find($request->order_id);
        if(!$order){
            return apiResponse(0, "No data");
        }
        $order->update(['state'=>'declined']);
        $restaurant = $order->restaurant;
        $notification = $restaurant->notifications()->create([
            'title'=>'Declined',
            'body'=>'Order no.'.$order->id.' is declined',
            'order_id'=>$request->order_id,
        ]);
        $tokens = $restaurant->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        if(count($tokens)){
            $title = $notification->title;
            $body = $notification->body;
            $data = ['order_id'=>$request->order_id];
            $send = notifyByFirebase($title, $body, $tokens, $data);
            info("notify by firebase:".$send);
        }
        return apiResponse(1, "Declined");
    }


    public function offer(Request $request){
        $offer = Offer::with('restaurant')->find($request->offer_id);
        if(!$offer){
            return apiResponse(0, "No data");
        }
        return apiResponse(1, "success", $offer);
    }

    public function product(Request $request){
        $product = Product::with('restaurant')->where('disabled', '=', 0)->find($request->product_id);
        if(!$product){
            return apiResponse(0, "No data");
        }
        return apiResponse(1, "success", $product);
    }

    public function restaurant(Request $request){
        $restaurant = Restaurant::with('district', 'categories')->where('is_active', '=', 1)->find($request->restaurant_id);
        if(!$restaurant){
            return apiResponse(0, "No data");
        }
        return apiResponse(1, "success", $restaurant);
    }

    public function review(Request $request){
        $restuarant = Restaurant::where('is_active', '=', 1)->find($request->restaurant_id);
        if (!$restuarant)
        {
            return apiResponse(0,'No data');
        }
        $reviews = $restuarant->reviews()->paginate(10);
        return apiResponse(1,'success',$reviews->load('client', 'restaurant'));
    }

}
