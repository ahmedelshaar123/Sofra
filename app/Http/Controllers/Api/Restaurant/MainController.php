<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Category;
use App\Offer;
use App\Order;
use App\PaymentMethod;
use App\Product;
use App\Restaurant;
use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function categories(){
        $categories = Category::all();
        return apiResponse(1, "success", $categories);
    }

    public function paymentMethods(){
        $payments = PaymentMethod::all();
        return apiResponse(1, "success", $payments);
    }

    public function newOffer(Request $request){
        $validator = validator()->make($request->all(), [
           'name'=>'required',
            'description'=>'required',
            'price'=>'required|numeric',
            'starting_at'=>'required|date',
            'ending_at'=>'required|date',
            'image'=>'required|image:mimes:jpeg,png,svg,gif,jpg|max:2048',
        ]);
        if($validator->fails()){
            return apiResponse(0 , $validator->errors()->first(), $validator->errors());
        }
        $offers = $request->user()->offers()->create($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renaming image
            $image->move($destinationPath, $name); // uploading file to given path
            $offers->update(['image' => '/uploads/offers/' . $name]);
        }
        return apiResponse(1, "success", $offers);
    }

    public function updateOffer(Request $request){
        $validator = validator()->make($request->all(), [
            'price'=>'numeric',
            'starting_at'=>'date',
            'ending_at'=>'date',
            'image'=>'image:mimes:jpeg,png,svg,gif,jpg|max:2048',
        ]);

        if($validator->fails()){
            return apiResponse(0 , $validator->errors()->first(), $validator->errors());
        }
        $offer = $request->user()->offers()->find($request->offer_id);
        if(!$offer){
            return apiResponse(0, "No data");
        }
        $offer ->update($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renaming image
            $image->move($destinationPath, $name); // uploading file to given path
            $request->user()->update(['image' => '/uploads/offers/' . $name]);
        }
        return apiResponse(1, "success", $offer->fresh());
    }

    public function deleteOffer(Request $request){
        $offer = $request->user()->offers()->find($request->offer_id);
        if(!$offer){
            return apiResponse(0, "No data");
        }
        $offer->delete();
        return apiResponse(1, "Deleted");
    }

    public function myOffers(Request $request){
        $offers = $request->user()->offers()->latest()->paginate(20);
        return apiResponse(1, "success", $offers);
    }



    public function myReviews(Request $request){
        $review = $request->user()->reviews()->latest()->paginate(10);
        return apiResponse(1, "success", $review->load('client','restaurant'));
    }

    public function newProduct(Request $request){
        $validator = validator()->make($request->all(),[
           'name'=>'required',
           'description'=>'required',
           'price'=>'required|numeric',
           'preparing_time'=>'required',
            'image'=>'required|image:mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return apiResponse(0 , $validator->errors()->first(), $validator->errors());
        }
        $products = $request->user()->products()->create($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/products/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renaming image
            $image->move($destinationPath, $name); // uploading file to given path
            $products->update(['image' => '/uploads/products/' . $name]);
        }
        return apiResponse(1, "success", $products);
    }

    public function myProducts(Request $request){
        $products = $request->user()->products()->where('disabled', 0)->latest()->paginate(20); //scope??
        return apiResponse(1, "success", $products);
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

    public function availability(Request $request){
        $validator = validator()->make($request->all(), [
           'availability'=>'required|in:opened,closed',
        ]);
        if($validator->fails()){
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }
        $request->user()->update(['availability'=>$request->availability]);
        return apiResponse(1, "success", $request->availability);
    }

    public function myNotifications(Request $request){
        $notifications = $request->user()->notifications()->with('order', 'order.client', 'order.restaurant', 'order.paymentMethod', 'order.client.district', 'order.restaurant.district')->latest()->paginate(20);
        return apiResponse(1, "success", $notifications);
    }

    public function updateProduct(Request $request){
        $validator = validator()->make($request->all(), [
            'price'=>'numeric',
            'image'=>'image:mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return apiResponse(0 , $validator->errors()->first(), $validator->errors());
        }
        $product = $request->user()->products()->find($request->product_id);
        if(!$product){
            return apiResponse(0 , "No data");
        }
        $product->update($request->all());
        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/products/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renaming image
            $image->move($destinationPath, $name); // uploading file to given path
            $request->user()->update(['image' => '/uploads/products/' . $name]);
        }
        return apiResponse(1, "updated",
            ['product'=>$product->fresh()]);
    }

    public function deleteProduct(Request $request){
        $product = $request->user()->products()->find($request->product_id);

        if(!$product){
            return apiResponse(0 , "No data");
        }

//        if(count($product->orders) > 0){
//            return apiResponse(0 , "Can not be deleted, there are orders associated with it");
//        }
        if($product->disabled == 1){
            $product->disabled = 0;
            $product->save();
            return apiResponse(1, "Enabled");
        }
        elseif($product->disabled == 0){
            $product->disabled = 1;
            $product->save();
            return apiResponse(1, "Disabled");
        }
    }

    public function myOrders(Request $request){
        $orders = $request->user()->orders()->where(function($order) use($request){
            if($request->has('state') && $request->state=='new'){
                $order->where('state','=','pending');
            }elseif($request->has('state') && $request->state=='current'){
                $order->where('state','=','accepted');
            }elseif($request->has('state') && $request->state=='previous'){
                $order->where('state','!=','pending');
                $order->orWhere('state','!=','accepted');
            }
        })->with('client','products')->latest()->paginate(10);
        return apiResponse(1,"success",$orders);
    }

    public function showOrder(Request $request){
        $order = Order::with('client','products')->find($request->order_id);
        if(!$order){
            return apiResponse(0, "No data");
        }
        return apiResponse(1, "success", $order);
    }

    public function acceptOrder(Request $request){
        $order = $request->user()->orders()->find($request->order_id);
        if(!$order){
            return apiResponse(0, "No data");
        }
        $order->update(['state'=>'accepted']);
        $client = $order->client;
        $notification = $client->notifications()->create([
           'title'=>'Accepted',
            'body'=>'Order no.'.$order->id.' is accepted',
            'order_id'=>$request->order_id,
        ]);
        $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        if(count($tokens)){
            $title = $notification->title;
            $body = $notification->body;
            $data = ['order_id'=>$request->order_id];
            $send = notifyByFirebase($title, $body, $tokens, $data);
            info("notify by firebase:".$send);
        }
        return apiResponse(1, "Accepted");
    }

    public function rejectOrder(Request $request){
        $order = $request->user()->orders()->find($request->order_id);
        if(!$order){
            return apiResponse(0, "No data");
        }
        $order->update(['state'=>'rejected']);
        $client = $order->client;
        $notification = $client->notifications()->create([
            'title'=>'Rejected',
            'body'=>'Order no.'.$order->id.' is rejected',
            'order_id'=>$request->order_id,
        ]);
        $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        if(count($tokens)){
            $title = $notification->title;
            $body = $notification->body;
            $data = ['order_id'=>$request->order_id];
            $send = notifyByFirebase($title, $body, $tokens, $data);
            info("notify by firebase:".$send);
        }
        return apiResponse(1, "Rejected");
    }

    public function confirmOrder(Request $request){
        $order = $request->user()->orders()->find($request->order_id);
        if(!$order){
            return apiResponse(0, "No data");
        }
        $order->update(['state'=>'confirmed']);
        $client = $order->client;
        $notification = $client->notifications()->create([
            'title'=>'Confirmed',
            'body'=>'Order no.'.$order->id.' is confirmed',
            'order_id'=>$request->order_id,
        ]);
        $tokens = $client->tokens()->where('token', '!=', '')->pluck('token')->toArray();
        if(count($tokens)){
            $title = $notification->title;
            $body = $notification->body;
            $data = ['order_id'=>$request->order_id];
            $send = notifyByFirebase($title, $body, $tokens, $data);
            info("notify by firebase:".$send);
        }
        return apiResponse(1, "Confirmed");
    }

    public function commissions(Request $request){
        $count = $request->user()->orders()->where('state', 'delivered')->count();
        $cost = $request->user()->orders()->where('state', 'delivered')->sum('cost');
        $commissions = $request->user()->orders()->where('state', 'delivered')->sum('commission');
        $payments = $request->user()->transactions()->sum('amount');
        $net_commissions = $commissions - $payments;
        $settings = Setting::find(1);
        $commission = $settings->commission;
        return apiResponse(1, "success", compact('count', 'cost', 'commissions', 'payments', 'net_commissions', 'commission'));


    }


}
