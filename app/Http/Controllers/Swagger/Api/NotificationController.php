<?php

namespace App\Http\Controllers\Swagger\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *
 *      path="/api/confirmation/code",
 *      summary="Активировать email или phone по коду",
 *      tags={"Notification"},
 *
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                      @OA\Property(property="code", type="integer", format="int32", description="Шестизначный код", minimum=100000, maximum=999999, example="000000"),
 *                  )
 *              },
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Successfully confirm notification",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", ref="#/components/schemas/UserResource"),
 *              @OA\Property(property="message", type="string", example="Successfully confirm email"),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="500",
 *          description="Ошибка на сервере",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Ошибка на сервере"),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="401",
 *          description="Не авторизован.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Не авторизован."),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="400",
 *          description="Ошибка, неверный код или он уже был подтверждён.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Ошибка, неверный код или он уже был подтверждён."),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="404",
 *          description="ошибка проверки кода Email/Phone",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Error confirm"),
 *          )
 *      ),
 *
 *      security={
 *         {"bearerAuth": {}}
 *      },
 *
 *),
 *
 * @OA\Post(
 *
 *      path="/api/confirmation/code/send",
 *      summary="Отрпавить код email или phone",
 *      tags={"Notification"},
 *
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                      @OA\Property(property="type", type="string", enum={"phone", "email"}, description="Тип отправки нотификации email/phone - указывать в поле type:email/phone"),
 *                  )
 *              },
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="500",
 *          description="Ошибка на сервере",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Ошибка на сервере"),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="401",
 *          description="Email/Phone уже подтверждён.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Email/Phone уже подтверждён."),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Успешная отправка нотификации",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Successfully notification send"),
 *          )
 *      ),
 *
 *      security={
 *          {"bearerAuth": {}}
 *      },
 *
 *
 * )
 *
 */

class NotificationController extends Controller
{


}
