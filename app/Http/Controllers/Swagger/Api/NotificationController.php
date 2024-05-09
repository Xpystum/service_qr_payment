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
 *
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Successfully confirm email",
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
 *          response="400",
 *          description="Ошибка, неверный код.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Ошибка, неверный код."),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="404",
 *          description="Error confirm - вылетает если не прошло проверку на email/phone в будущем пока в тесте",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Error confirm"),
 *          )
 *      ),
 *
 *
 *
 *      security={
 *         {"bearerAuth": {}}
 *      },
 *
 *),
 *
 * @OA\Post(
 *
 *      path="/api/confirmation/code/again",
 *      summary="Активировать email или phone по коду",
 *      tags={"Notification"},
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
 *          response="404",
 *          description="Email подтверждён",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Email подтверждён"),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Successfully email send - *старый код для активации был заменён",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Successfully email send"),
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
