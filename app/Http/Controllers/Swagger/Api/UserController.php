<?php

namespace App\Http\Controllers\Swagger\Api;
use App\Http\Controllers\Controller;

/**
 * @OA\GET(
 *
 *      path="/api/user",
 *      summary="Получить всех user - которые принадлежат админу кабинета (owner)",
 *      tags={"User"},
 *
 *       @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={}
 *                  )
 *               },
 *           ),
 *       ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array" , @OA\Items(ref="#/components/schemas/UserResource")),
 *              @OA\Property(property="message", type="string", example="Successfully return users associal user:admin"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *           response=500,
 *           description="Общая ошибка сервера.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error server"),
 *               @OA\Property(property="code", type="integer", example="500"),
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=401,
 *           description="Ошибка авторизации.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *           ),
 *       ),
 *
 *
 *      security={
 *          {"bearerAuth": {}}
 *      },
 *
 * ),
 *
 *  @OA\Post(
 *
 *      path="/api/user/edit",
 *      summary="Изменить данные у user",
 *      tags={"Edit\User"},
 *
 *
 *
 * ),
 *
 *
 *
 *
 */
class UserController extends Controller
{

}
