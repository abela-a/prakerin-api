<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] =  $authUser->createToken('auth-prakerin')->plainTextToken;
            $success['name'] =  $authUser->name;

            return $this->sendResponse($success, $authUser->name . ' berhasil login.');
        } else {
            return $this->sendError(__('auth.failed'));
        }
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Gagal mendaftar.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] =  $user->createToken('auth-prakerin')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'Pengguna baru berhasil dibuat.');
    }
}
