<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserRequest;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UsersController extends ApiController
{
    protected $userTransformer;

    public function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;

        $this->middleware('auth:api')->except(['login', 'register']);

    }

    public function login(UserRequest $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $success =  $user->createToken('MyApp')->accessToken;

            return response()->json(['success' => $success], 200);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }


    public function register(UserRegisterRequest $request)
    {

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function index()
    {
        $limit = Input::get('limit');
        if ($limit) {
            $users = User::paginate($limit);
        } else {
            $users = User::paginate();
        }

        return $this->respondWithPagination($users, [
            'data' => $this->userTransformer->transformCollection($users->all())
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->respondNotFound('User does not exist.');
        }

        if(request()->user()->id != $user->id ) {
            return $this->respondDeniedPermission("You don't have permission to see this user");
        }

        return $this->respond([
            'data' => $this->userTransformer->transform($user)
        ]);
    }

}
