<?php

namespace App\Http\Controllers\Swagger\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



/**
 * @OA\GET(
 *
 *      path="/api/driver-info/storage",
 *      summary="получение списков параметров всех платежек",
 *      tags={"Driver-Info"},
 *
 *      @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={},
 *                  )
 *               },
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/PaymentSettings"),
 *               @OA\Property(property="message", type="string", example="Get all child organizations of the user"),
 *           ),
 *       ),
 *
 *       @OA\Response(
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
 *       security={
 *          {"bearerAuth": {}}
 *       },
 *
 *
 * ),
 *
 * @OA\PUT(
 *
 *      path="/api/driver-info/save",
 *      summary="Сохранения данных",
 *      tags={"Driver-Info"},
 *
 *      @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={},
 *                  )
 *               },
 *           ),
 *       ),
 *
 *       @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={
 *                           @OA\Property(property="type_id", type="integer", description="Идентификатор типа платежа (прислать id метода payment (PaymentMethods) )", example=1),
 *                           @OA\Property(property="parametr", type="string", description="Параметр", example="apikey, password, shopId - параметры можно получить по /api/driver-info/save"),
 *                           @OA\Property(property="value", type="string", description="Значение параметра", example="Apikey:2q34dsfsef")
 *                      }
 *                  )
 *               },
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=204,
 *           description="Ok - данные были обновлены, или записаны",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/PaymentSettings"),
 *               @OA\Property(property="message", type="string", example="Successfully save driver info"),
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=404,
 *           description="Ошибка обновление/записи данных.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string"), nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed save driver info"),
 *           ),
 *       ),
 *
 *       @OA\Response(
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
 *       security={
 *          {"bearerAuth": {}}
 *       },
 *
 *
 *
 * ),
 *
 * @OA\GET(
 *
 *      path="/api/driver-info/{paymentMethod:id}/show",
 *      summary="Получение всех значений у метода оплаты по [user] [payment_method]",
 *      tags={"Driver-Info"},
 *      @OA\Parameter(
 *         name="paymentMethod:id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="int", format="id"),
 *         description="ID Платежа"
 *     ),
 *
 *      @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={},
 *                  )
 *               },
 *           ),
 *       ),
 *
 *
 *        @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/PaymentSettings"),
 *               @OA\Property(property="message", type="string", example="Return all info driver by type"),
 *           ),
 *       ),
 *
 *
 *       @OA\Response(
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
 *       security={
 *          {"bearerAuth": {}}
 *       },
 * ),
 *
 *
 * @OA\Schema(
 *     schema="PaymentSettings",
 *     type="object",
 *     @OA\Property(property="ykassa", type="object",
 *         @OA\Property(property="Shop id", type="string", description="Идентификатор магазина", example="12345"),
 *         @OA\Property(property="Key", type="string", description="Секретный ключ", example="secret_key_value")
 *     ),
 *     @OA\Property(property="test", type="object",
 *         @OA\Property(property="Api Key", type="string", description="API ключ для тестирования", example="test_api_key")
 *     )
 * )
 *
 *
 *
 */
class DriverInfoController extends Controller
{
    //
}
