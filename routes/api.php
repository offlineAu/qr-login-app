use Illuminate\Support\Str;
use App\Models\LoginToken;
use Illuminate\Http\Request;
use App\Models\User;

// POST /api/request-token
Route::post('/request-token', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $token = Str::uuid()->toString(); // unique token

    $loginToken = LoginToken::create([
        'user_id' => $user->id,
        'token' => $token,
    ]);

    return response()->json([
        'token' => $token,
        'qr_url' => route('qr.login', ['token' => $token])
    ]);
});

// POST /api/confirm-token
Route::post('/confirm-token', function (Request $request) {
    $request->validate(['token' => 'required']);

    $token = LoginToken::where('token', $request->token)
                ->where('used', false)
                ->first();

    if (!$token) {
        return response()->json(['message' => 'Invalid or already used token'], 400);
    }

    $token->used = true;
    $token->save();

    // Return user info or auth token if needed
    return response()->json(['message' => 'Token confirmed']);
});
