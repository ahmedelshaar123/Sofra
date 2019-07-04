<?php

namespace App\Http\Controllers\Api\Client;

use App\Client;
use App\Mail\ResetPassword;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = validator()->make($request->all(),[
           'name'=>'required',
           'email'=>'required|unique:clients',
           'phone'=>'required|unique:clients|digits:11',
           'district_id'=>'required|exists:districts,id',
           'description'=>'required',
           'password'=>'required|confirmed',
        ]);
        if($validator->fails()){
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }
        $request->merge(['password'=>bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = str_random(60);
        $client->save();
        return apiResponse(1, "success", [
           'api_token'=>$client->api_token,
           'client'=>$client->load('district.city'),
        ]);
    }

    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return apiResponse(0, $validator->errors()->first(), $validator->errors());
        }
        $client = Client::where('email', $request->email)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return apiResponse(1, "success", [
                    'api_token' => $client->api_token,
                    'client' => $client->load('district.city'),
                ]);
            } else {

            return apiResponse(0, "password is not correct");
        }
        } else {
            return apiResponse(0, "email is not registered");
        }
    }

        public function profile(Request $request){
            $validator = validator()->make($request->all(),[
               'password'=>'confirmed',
               'email'=>Rule::unique('clients')->ignore($request->user()->id),
                'phone'=>Rule::unique('clients')->ignore($request->user()->id),
                'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'district_id'=>'exists:districts,id',
            ]);
            if($validator->fails()){
                return apiResponse(0, $validator->errors()->first(), $validator->errors());
            }
            $request->user()->update($request->all());

            if($request->has('password')){
                $request->user()->password = bcrypt($request->password);
                $request->user()->save();
            }

            if($request->hasFile('image')){
                $path = public_path();
                $destinationPath = $path . '/uploads/clients/'; // upload path
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension(); // getting image extension
                $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renaming image
                $image->move($destinationPath, $name); // uploading file to given path
                if (file_exists($request->user()->image))
                    unlink($request->user()->image);
                $request->user()->update(['image' => 'uploads/clients/' . $name]);
            }
            $request->user()->save();

            return apiResponse(1, "updated", [
                'client'=>$request->user()->fresh()->load('district.city'),
            ]);
        }

        public function resetPassword(Request $request){
            $validator = validator()->make($request->all(),[
               'email'=>'required',
            ]);
            if($validator->fails()){
                return apiResponse(0 , $validator->errors()->first(), $validator->errors());
            }

            $user = Client::where('email', $request->email)->first();
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

        public function newPassword(Request $request)
        {
            $validator = validator()->make($request->all(), [
                'pin_code' => 'required',
                'password' => 'required|confirmed',

            ]);
            if ($validator->fails()) {
                return apiResponse(0, $validator->errors()->first(), $validator->errors());
            }
            $client = Client::where('pin_code', $request->pin_code)->where('pin_code', '!=', null)->first();
            if ($client) {
                $update = $client->update(['password' => bcrypt($request->password), 'pin_code' => null]);
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
