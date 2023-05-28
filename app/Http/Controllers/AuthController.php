<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Fetches all users
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $users = $this->userRepository->findMany();
        $users = UserResource::collection($users)->response()->getData();

        return Response::successResponseWithData($users);
    }

    public function login(LoginRequest $request) : JsonResponse
    {
        $userData = $request->validated();

        if (Auth::attempt($userData)) {
            $token = config('keys.token');
            $accessToken = Auth::user()->createToken($token)->plainTextToken;
            $data = auth()->user();
            return Response::successResponseWithData($data, 'Login successful', 200, $accessToken);
        }
        return Response::errorResponse('Invalid Login credentials', 400);
    }

    public function register(CreateUserRequest $request) : JsonResponse
    {
        $userData = $request->validated();
        $user = $this->userRepository->create($userData);

        return Response::successResponseWithData($user, 'User created successfully', 201);
    }

    /**
     * Deletes current access token of user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return Response::successResponse('Logged out successfully');
    }

    public function delete(User $user) : JsonResponse
    {
        if ( $user->id === auth()->id() || $user->is_super_admin ){
            return Response::errorResponse('Bad Request', 400);
        }

        $this->userRepository->delete($user);

        return Response::successResponse();
    }

    public function changePassword(ChangePasswordRequest $request) : JsonResponse
    {

    }

    public function show(User $user) : JsonResponse
    {
        $user = new UserResource($user);

        return Response::successResponseWithData($user);
    }
}
