<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Exception\DatabaseException;
use Exception;

class ApiAuthController extends Controller
{
    protected $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        $usersSnapshot = $this->database->getReference('users')
            ->orderByChild('email')
            ->equalTo($credentials['email'])
            ->getSnapshot();
        $users = $usersSnapshot->getValue();

        if (!$users || !Hash::check($credentials['password'], $users[array_key_first($users)]['password'])) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $userId = array_key_first($users);
        $user = $users[$userId];
        $token = Str::random(60);

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $userId,
                'name' => $user['name'],
                'email' => $user['email']
            ],
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:2|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $newUser = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        try {
            $userReference = $this->database->getReference('users')->push($newUser);
            $userKey = $userReference->getKey();

            return response()->json([
                'success' => true,
                'message' => 'User successfully registered!',
                'data' => ['user_id' => $userKey],
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
