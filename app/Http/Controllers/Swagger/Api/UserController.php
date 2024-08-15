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
 * @OA\POST(
 *
 *      path="/api/user",
 *      summary="создание user который относится к админу: casier, manager (создавать может только admin)",
 *      tags={"User"},
 *
 *      @OA\RequestBody(
 *          request="UserRegistration",
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={
 *                          @OA\Property(property="email", type="string", description="Уникальный адрес электронной почты"),
 *                          @OA\Property(property="phone", type="string", description="Уникальный номер телефона"),
 *                          @OA\Property(
 *                              property="role",
 *                              type="string",
 *                              enum={"manager", "cashier"},
 *                              description="Тип пользователя, может быть 'manager' или 'cashier'"
 *                          ),
 *                          @OA\Property(property="password", type="string", description="Пароль пользователя"),
 *                     },
 *                      required={"email", "phone", "type", "password"}
 *                  )
 *              }
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object" , ref="#/components/schemas/UserResource"),
 *              @OA\Property(property="message", type="string", example="Successfully create user"),
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
 *
 *
 * ),
 *
 * @OA\PUT(
 *
 *      path="/api/user",
 *      summary="обновление данных у user",
 *      tags={"User"},
 *
 *      @OA\RequestBody(
 *          request="UserRegistration",
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="UserRequest",
 *                      type="object",
 *                      required={"id"},
 *                          @OA\Property(property="id", type="integer", description="ID пользователя"),
 *                          @OA\Property(property="phone", type="string", description="Телефон пользователя", pattern="/^(\+7|8)(\d{10})$/"),
 *                          @OA\Property(property="email", type="string", description="Электронная почта пользователя", format="email", maxLength=100),
 *                          @OA\Property(property="first_name", type="string", description="Имя пользователя", minLength=2, maxLength=255),
 *                          @OA\Property(property="last_name", type="string", description="Фамилия пользователя", minLength=2, maxLength=255),
 *                          @OA\Property(property="father_name", type="string", description="Отчество пользователя", minLength=2, maxLength=255),
 *                 )
 *              }
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object" , ref="#/components/schemas/UserResource"),
 *              @OA\Property(property="message", type="string", example="Successfully update information user"),
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
 *       @OA\Response(
 *           response=400,
 *           description="Пользователь не до конца прошёл регистрацию - не подтвердил почту",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Пользователь не до конца прошёл регистрацию."),
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
 * @OA\DELETE(
 *
 *      path="/api/user",
 *      summary="удаление user от user:admin",
 *      tags={"User"},
 *
 *      @OA\RequestBody(
 *          request="UserRegistration",
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      schema="UUIDRequest",
 *                      type="object",
 *                      required={"uuid"},
 *                      @OA\Property(property="uuid", type="string", description="UUID пользователя", format="uuid")
 *                  )
 *              }
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object" , nullable=true),
 *              @OA\Property(property="message", type="string", example="Successfully deleted user"),
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
 *       @OA\Response(
 *           response=400,
 *           description="Пользователь не до конца прошёл регистрацию - не подтвердил почту",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , nullable=true),
 *               @OA\Property(property="message", type="string", example="Successfully deleted user"),
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=404,
 *           description="Пользователь не до конца прошёл регистрацию - не подтвердил почту",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Failed deleted user"),
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
 *
 */
class UserController extends Controller
{

}
