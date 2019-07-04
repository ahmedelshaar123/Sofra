<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Mail\ResetPassword;
use App\Restaurant;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{

    public function register(Request $request){
        $validator =validator()->make($request->all(), [
           'name'=>'required',
           'district_id'=>'required|exists:districts,id',
            'email'=>'required|unique:restaurants',
            'password'=>'required|confirmed',
            'min_charge'=>'required|numeric',
            'delivery_fees'=>'required|numeric',
            'phone'=>'required|digits:11|unique:restaurants',
            'whatsapp'=>'required|digits:11|unique:restaurants',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories'=>'required|array',
            'categories.*'=>'required|exists:categories,id',

        ]);

        if($validator->fails()){
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }

        $request->merge(['password'=>bcrypt($request->password)]);
        $restaurant = Restaurant::create($request->all());
        $restaurant->api_token = str_random(60);
        $restaurant->save();

        if($request->has('categories')){
            $restaurant->categories()->sync($request->categories);
        }

        if ($request->hasFile('image')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $image->move($destinationPath, $name); // uploading file to given path
            $restaurant->update(['image' => 'uploads/restaurants/' . $name]);
        }

        return apiResponse(1, "success", [
           'api_token'=>$restaurant->api_token,
           'restaurant'=>$restaurant->load('district.city', 'categories'),
        ]);



    }
    public function login(Request $request){
        $validator = validator()->make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);
        if($validator->fails()){
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }

        $restaurant = Restaurant::where('email', $request->email)->first();
        if($restaurant){
            if(Hash::check($request->password, $restaurant->password)){
                if($restaurant->is_active == 0){
                    return apiResponse(0, "Not activated yet");
                }
                return apiResponse(1, "success",[
                    'api_token'=>$restaurant->api_token,
                    'restaurant'=>$restaurant->load('district.city', 'categories'),
                ]);
            }else{
                return apiResponse(0, "password is not correct");
            }
        }else{
            return apiResponse(0, "email is not registered");
        }

    }

    public function profile(Request $request){
        $validator = validator()->make($request->all(), [
           'password'=>'confirmed',
           'email'=>Rule::unique('restaurants')->ignore($request->user()->id) ,
            'phone'=>Rule::unique('restaurants')->ignore($request->user()->id) ,
            'whatsapp'=>Rule::unique('restaurants')->ignore($request->user()->id) ,
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'min_charge'=>'numeric',
            'delivery_fees'=>'numeric',
            'categories'=>'array',
            'categories.*'=>'exists:categories,id',
            'district_id'=>'exists:districts,id',

        ]);
        if($validator->fails()){
            return apiResponse(0 , $validator->errors()->first(), $validator->errors());
        }
        $request->user()->update($request->all());
        if($request->has('password')){
            $request->user()->password = bcrypt($request->password);
            $request->user()->save();
        }

        if($request->has('categories')){
            $request->user()->categories()->sync($request->categories);
        }

        if($request->hasFile('image')){
            $path = public_path();
            $destinationPath = $path . '/uploads/restaurants/'; // upload path
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renaming image
            $image->move($destinationPath, $name); // uploading file to given path
            if (file_exists($request->user()->image))
                unlink($request->user()->image);
            $request->user()->update(['image' => 'uploads/restaurants/' . $name]);
        }

        return apiResponse(1, "updated", [
            'restaurant'=>$request->user()->fresh()->load('district.city', 'categories'),
        ]);

    }

    public function resetPassword(Request $request){
        $validator = validator()->make($request->all(),[
            'email'=>'required',
        ]);
        if($validator->fails()){
            return apiResponse(0 , $validator->errors()->first(), $validator->errors());
        }

        $user = Restaurant::where('email', $request->email)->first();
        if($user){
            $code = rand(111111,999999);
            $update = $user->update(['pin_code'=>$code]);
            if($update){
                Mail::to($request->email)
                    ->send(new ResetPassword($user));
                return apiResponse(1, "check your email",[
                    'pin_code'=>$code,
                ] );
            }else{
                return apiResponse(0 , "try again");
            }
        }else{
            return apiResponse(0 , "email does not exist");
        }

    }

    public function newPassword(Request $request){
        $validator = validator()->make($request->all(), [
            'pin_code' => 'required',
            'password' => 'required|confirmed',

        ]);
        if ($validator->fails()) {
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }
        $restaurant = Restaurant::where('pin_code', $request->pin_code)->where('pin_code', '!=', null)->first();
        if ($restaurant) {
            $update = $restaurant->update(['password' => bcrypt($request->password), 'pin_code' => null]);
            if ($update) {
                return apiResponse(1, "password changed");
            } else {
                return apiResponse(0, "try again");
            }

        } else {
            return apiResponse(0, "incorrect code");
        }
    }

    public function registerToken(Request $request){
        $validator = validator()->make($request->all(),[
            'token'=>'required|unique:tokens',
            'platform'=>'required|in:android,ios',
        ]);
        if($validator->fails()){
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }
        Token::where('token', $request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return apiResponse(1, "registered");
    }

    public function deleteToken(Request $request){
        $validator = validator()->make($request->all(), [
            'token'=>'required',
        ]);
        if($validator->fails()){
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }
        Token::where('token', $request->token)->delete();
        return apiResponse(1, "deleted");
    }
}
