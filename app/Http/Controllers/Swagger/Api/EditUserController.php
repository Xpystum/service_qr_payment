<?php

namespace App\Http\Controllers\Swagger\Api;
use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *
 *      path="/api/user/edit",
 *      summary="Изменить данные у user",
 *      tags={"Edit\User"},
 *
 *       @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="id", type="integer", description="Id у User", example="1"),
 *
 *                     @OA\Property(property="email", type="string", format="email", description="User's email address", example="test@gmail.com"),
 *                     @OA\Property(property="phone", type="string", description="User's phone number", pattern="^\+?[0-9]{1,3}[0-9]{9}$", example="+79200264425"),
 *
 *                     @OA\Property(property="first_name", type="string", description="Имя", example="Ваня"),
 *                     @OA\Property(property="last_name", type="string", description="Фамилие", example="Лучший"),
 *                     @OA\Property(property="father_name", type="string", description="Отчество", example="СеньёрВерстальщик"),
 *                 )
 *              },
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", ref="#/components/schemas/UserResource"),
 *              @OA\Property(property="message", type="string", example="Successfully update information user"),
 *          ),
 *      ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Может быть множество ошибок валдиации по 422 (Например при указании только id  в параметры выпадет ошибка)",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The id field is required. (and 1 more error)" ),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="array",
 *                     @OA\Items(
 *                         type="string",
 *                         example="The id field is required."
 *                     ),
 *                     description="An array of error messages related to the id field."
 *                 )
 *              ),
 *         ),
 *     ),
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
 *      @OA\Response(
 *          response=401,
 *          description="Пользователь не подтвердил email/phone",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Пользователь не до конца прошёл регистрацию."),
 *          ),
 *       ),
 *
 *      security={
 *          {"bearerAuth": {}}
 *      },
 *
 * ),
 *
 *
 *
 *
 */
class EditUserController extends Controller
{

}
