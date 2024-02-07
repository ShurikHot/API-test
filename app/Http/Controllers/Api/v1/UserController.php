<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UsersListRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function getUsers(UsersListRequest $request)
    {
        $request->count = $request->has('count') ? $request->count : 5;

        if ($request->has('offset')) {
            $offset = $request->offset;
        } elseif ($request->has('page')) {
            $offset = $request->page - 1 * $request->count;
            $request->offset = null;
        } else {
            $offset = 0;
            $request->page = 1;
        }
        $users = User::query()
            ->offset($offset)
            ->orderByDesc('created_at')
            ->paginate($request->count);
        $total_pages = $users->lastPage();
        $total_users = $users->total();

        if ($request->page > $total_pages) {
            return response()->json([
                'success' => false,
                'message' => 'Page not found'
            ], 404);
        }

        if ($request->page > $total_pages - 1) {
            $nextPage = null;
        } else {
            $nextPage = url('/api/v1/users?page=' . $request->page + 1 . '&count=' . $request->count);
        }

        if ($request->page < 2) {
            $prevPage = null;
        } else {
            $prevPage = url('/api/v1/users?page=' . $request->page - 1 . '&count=' . $request->count);
        }

        $usersArr = UserResource::collection($users)->toArray($request);

        return response()->json([
            'success' => true,
            'page' => $request->page,
            'offset' => $request->offset,
            'total_pages' => $total_pages,
            'total_users' => $total_users,
            'count' => $request->count,
            'links' => [
                'next_url' => $nextPage,
                'prev_url' => $prevPage,
            ],
            'users' => $usersArr
        ], 200);
    }

    public function getUser($id, Request $request)
    {
        if (is_numeric($id) && intval($id) == $id) {
            $user = User::query()->where('id', $id)->get();
        } else {
            return response()->json([
                'success' => false,
                'message' => "Validation failed",
                'fails' => [
                    'user_id' => "The user_id must be an integer.",
                ]
            ], 400);
        }

        if (count($user)) {
            $userArr = UserResource::collection($user)->toArray($request);
            return response()->json([
                'success' => true,
                'user' => $userArr,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "The user with the requested identifier does not exist",
                'fails' => [
                    'user_id' => "User not found"
                ]
            ], 404);
        }
    }

    public function createUser(UserCreateRequest $request)
    {
        $credentials = [
            'email' => 'admin@admin.com',
            'password' => '111',
        ];
        if (!Auth::attempt($credentials)) {
            return 'The provided credentials do not match our records';
        }
        $admin = Auth::user();

        $tokenHeader = $request->header('Token');

        if ($tokenHeader) {
            $urlToken = url(route('getToken'));
            $token = Http::get($urlToken)->json('token');
            if (!($tokenHeader == $token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'The token expired.'
                ], 401);
            }
        }

        $userIsUniq = User::query()->where('email', $request->email)->orWhere('phone', $request->phone)->get();
        if (count($userIsUniq) != 0) {
            return response()->json([
                'success' => false,
                'message' => "User with this phone or email already exist"
            ], 409);
        }

        $photo = self::optimizePhoto();
        if ($photo) {
            $data = $request->toArray();
            $data['photo'] = url($photo);
            $user = User::query()->create($data);
            if ($user) {
                if ($admin->tokens) {
                    foreach ($admin->tokens as $item) {
                        if ($item->token == $tokenHeader) {
                            $item->delete();
                        }
                    }
                }
                return response()->json([
                    'success' => true,
                    'user_id' => $user->id,
                    'message' => "New user successfully registered"
                ]);
            }
        }
    }

    public static function optimizePhoto()
    {
        $uploadDir = 'images/users/';
        $file = $_FILES['photo'];
        if (!empty($_FILES)) {
            $uploadFile = $uploadDir . "5b977ba" . fake()->lexify('????????') . ".jpg";
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            \Tinify\setKey("nrLmkDllDnGg1K0Jd86nxFDx4br91WjV");

            $source = \Tinify\fromFile($uploadFile);
            $resized = $source->resize([
                "method" => "cover",
                "width" => 500,
                "height" => 500
            ]);
            $resized->toFile($uploadFile);

            return $uploadFile;
        }
        return false;
    }
}
