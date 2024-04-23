<?php

namespace App\Services\Auth\App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Modules\User\Resources\UserResource;
use App\Services\Auth\DTO\UserAttemptDTO;
use App\Services\Auth\Traits\TraitController;
use Illuminate\Http\Request;

//для преобразование массива с сообщением
use function App\Helpers\array_success;



class AuthController extends Controller
{
    use TraitController;

    /**
     * Возвращать jwt токен если мы нашли юзера.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $json_token = $this->authService->attemptUserAuth(
            new UserAttemptDTO(
                email: $request->email,
                phone: $request->phone,
                password: $request->password,
            )
        );

        abort_unless($json_token, 400, "Ошибка поиска User - Bad Request" );

        return response()->json(array_success($json_token, 'Successfully login'), 200);
    }

    /**
     * Возвращать user под полученному токену в bearer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $user = $this->authService->getUserAuth();

        abort_unless($user, 401, "Unauthorized" );

        $userResource = new UserResource($user);

        #TODO Добавить ресурс возврата user (не полностью)
        return response()->json(array_success( $userResource, 'Successfully return user'), 200);
    }

    /**
     * Удалить актуальный токен.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {

        $status = $this->authService->logout();

        #TODO ошибку слать json пакетом?
        abort_unless($status, 401, "Unauthorized" );

        return response()->json(array_success(message: 'Successfully logged out'), 200);
    }

    /**
     * Удалить сатрый токен и вернуть новый.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        $token = $this->authService->refresh();

        abort_unless($token, 401, "Unauthorized");

        return response()->json(array_success($token , 'Successfully refresh new token'), 200);
    }

    /**
     * Сигнатура токена.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }
}
