<?php

namespace App\Http\Controllers\Swagger\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/**
 * @OA\GET(
 *
 *      path="/api/payment/{payment:uuid}",
 *      summary="Получение конкретного payment по uuid",
 *      tags={"Payment"},
 *      @OA\Parameter(
 *         name="payment:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID платежа"
 *     ),
 *
 *     @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={}
 *                  )
 *               },
 *           ),
 *     ),
 *
 *       @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/PaymentResource"),
 *               @OA\Property(property="message", type="string", example="Show payment by uuid"),
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
 * ),
 *
 * @OA\GET(
 *
 *      path="/api/payment",
 *      summary="Получение всех активных методов оплаты",
 *      tags={"Payment"},
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
 *       @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array" , @OA\Items(ref="#/components/schemas/PaymentMethodResource")),
 *               @OA\Property(property="message", type="string", example="Return all active payment methods"),
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
 * ),
 *
 * @OA\Schema(
 *      schema="PaymentMethodResource",
 *      title="Payment Resource",
 *      type="object",
 *      properties={
 *          @OA\Property(property="name", type="string", description="Название метода оплаты"),
 *          @OA\Property(property="driver", type="string", description="Driver метода оплаты"),
 *          @OA\Property(property="active", type="bool", description="Активна ли оплата"),
 *          @OA\Property(property="driver_currency_id", type="string", description="Валюта оплаты"),
 *          @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *          @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-02T00:00:00Z"),
 *      },
 *
 * ),
 *
 * @OA\GET(
 *
 *      path="/api/payment/{payment:uuid}/process",
 *      summary="Получение значений по драйверу (Непосредственно оплата и получение СПБ - ссылки) - в тесте",
 *      tags={"Payment"},
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
 *       @OA\Response(
 *           response=201,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/PaymentMethodResource"),
 *               @OA\Property(property="message", type="string", example="Successfully create spb payment"),
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=404,
 *           description="Ошибка при получении SPB от драйвера",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string") , nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed create spb payment")
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
 * ),
 *
 */
class PaymentController extends Controller
{
    //
}
