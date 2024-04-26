<?php


namespace App\Http\Controllers\Swagger\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *
 *      path="/api/login",
 *      summary="вернуть токен для user по email/phone и password",
 *      tags={"Login\Registration"},
 *
 *       @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="email", type="string", format="email", description="User's email address", example="test@gmail.com"),
 *                     @OA\Property(property="phone", type="string", description="User's phone number", pattern="^\+?[0-9]{1,3}[0-9]{9}$", example="+79200264425"),
 *                     @OA\Property(property="password", type="string", format="password", description="User's password", example="Pas123!"),
 *                 )
 *              },
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", ref="#/components/schemas/BearerToken"),
 *              @OA\Property(property="message", type="string", example="Successfully return user"),
 *          ),
 *      ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Нужно указать только email или phone",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Only Email or Phone"),
 *         ),
 *     ),
 *
 *     @OA\Response(
 *          response=404,
 *          description="Ошибка поиска user.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="User not found"),
 *              @OA\Property(property="code", type="integer", example="404"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 *
 * ),
 *
 *
 *
 *
 *
 *
 */

class LoginController extends Controller
{

}
