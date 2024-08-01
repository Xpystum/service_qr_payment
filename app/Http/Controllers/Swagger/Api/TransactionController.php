<?php

namespace App\Http\Controllers\Swagger\Api;

use App\Http\Controllers\Controller;


/**
 * @OA\GET(
 *
 *      path="/api/transaction/{terminal:uuid}/pagination",
 *      summary="Вернуть транзакции пагинацией по терминалу",
 *      tags={"Transaction"},
 *      @OA\Parameter(
 *          name="terminal:uuid",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="string", format="uuid"),
 *          description="UUID транзакции"
 *      ),
 *
 *       @OA\RequestBody(
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
 *               @OA\Property(property="data", type="array" , @OA\Items(ref="#/components/schemas/TransactionResource")),
 *               @OA\Property(property="message", type="string", example="Successfully return transaction pagination"),
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
 *
 *       @OA\Response(
 *           response=404,
 *           description="Ошибка возврата пагинации.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string"), nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed return transaction"),
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
 *      path="/api/transaction/{terminal:uuid}/all",
 *      summary="Вернуть все транзакции у терминал без пагинации",
 *      tags={"Transaction"},
 *      @OA\Parameter(
 *          name="terminal:uuid",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="string", format="uuid"),
 *          description="UUID транзакции"
 *      ),
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
 *      @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array" , @OA\Items(ref="#/components/schemas/TransactionResource")),
 *               @OA\Property(property="message", type="string", example="Get all transaction by terminal"),
 *           ),
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
 *       security={
 *          {"bearerAuth": {}}
 *       },
 *
 * ),
 *
 * * @OA\GET(
 *
 *      path="/api/transaction/{terminal:uuid}",
 *      summary="Вернуть транзакцию по uuid",
 *      tags={"Transaction"},
 *      @OA\Parameter(
 *          name="terminal:uuid",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="string", format="uuid"),
 *          description="UUID транзакции"
 *      ),
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
 *      @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/TransactionResource"),
 *               @OA\Property(property="message", type="string", example="Show transaction by uuid"),
 *           ),
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
 *       security={
 *          {"bearerAuth": {}}
 *       },
 *
 * ),
 *
 * @OA\POST(
 *
 *      path="/api/transaction",
 *      summary="Вернуть транзакцию по uuid",
 *      tags={"Transaction"},
 *
 *      @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={
 *                          @OA\Property(property="amount", type="number", format="float"),
 *                          @OA\Property(property="terminal_uuid", type="string", format="uuid")
 *                      },
 *                  )
 *               },
 *           ),
 *       ),
 *
 *      @OA\Response(
 *           response=404,
 *           description="По uuid такой записи terminala не сущесвует.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message", type="string", example="Такой записи по uuid не существует"),
 *           ),
 *      ),
 *
 *      @OA\Response(
 *           response=201,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/TransactionResource"),
 *               @OA\Property(property="message", type="string", example="Successfully create transaction"),
 *           ),
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
 *       security={
 *          {"bearerAuth": {}}
 *       },
 *
 *
 * ),
 *
 *
 * @OA\POST(
 *
 *      path="/api/transaction/{transaction:uuid}/payment",
 *      summary="Cоздание payment",
 *      tags={"Transaction"},
 *      @OA\Parameter(
 *          name="transaction:uuid",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="string", format="uuid"),
 *          description="UUID транзакции",
 *      ),
 *
 *      @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      type="object",
 *                      properties={
 *                          @OA\Property(property="uuid", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *                          @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *                          @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-02T00:00:00Z"),
 *                          @OA\Property(property="status", type="string", example="pending"),
 *                          @OA\Property(property="amount", type="number", format="float", example=100.50),
 *                          @OA\Property(property="driver", type="string", example="John Doe", description="Драйвер оплаты,список можно получить по другому endpoint"),
 *                      },
 *                  )
 *               },
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=404,
 *           description="Ошибка создание payment.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string"), nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed create payment for transactions"),
 *           ),
 *      ),
 *
 *      @OA\Response(
 *           response=201,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/PaymentResource"),
 *               @OA\Property(property="message", type="string", example="Successfully create payment for transactions"),
 *           ),
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
 *       security={
 *          {"bearerAuth": {}}
 *       },
 *
 *
 * ),
 *
 *
 * @OA\GET(
 *
 *      path="/api/transaction/{transaction:uuid}/payment",
 *      summary="Вернуть все возможные payment по transaction",
 *      tags={"Transaction"},
 *      @OA\Parameter(
 *          name="transaction:uuid",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="string", format="uuid"),
 *          description="UUID транзакции",
 *      ),
 *
 *
 *      @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array" , @OA\Items(ref="#/components/schemas/PaymentResource")),
 *               @OA\Property(property="message", type="string", example="Show transaction by uuid"),
 *           ),
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
 *       security={
 *          {"bearerAuth": {}}
 *       },
 *
 * ),
 *
 *
 *
 * @OA\Schema(
 *      schema="PaymentResource",
 *      title="Payment Resource",
 *      type="object",
 *      properties={
 *          @OA\Property(property="uuid", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *          @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *          @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-02T00:00:00Z"),
 *          @OA\Property(property="status", type="string", example="pending"),
 *          @OA\Property(property="amount", type="number", format="float", example=100.50),
 *          @OA\Property(property="driver", type="string", example="John Doe")
 *      },
 *
 * ),
 *
 *
 *
 * @OA\Schema(
 *      schema="TransactionResource",
 *      title="Transaction Resource",
 *      type="object",
 *      properties={
 *          @OA\Property(property="driver_currency_id", type="integer"),
 *          @OA\Property(property="amount", type="string"),
 *          @OA\Property(property="uuid", type="string"),
 *          @OA\Property(property="status", type="string"),
 *          @OA\Property(property="created_at", type="string", format="date-time"),
 *          @OA\Property(property="code", type="integer", example="500"),
 *      },
 *
 * ),
 *
 *
 */
class TransactionController extends Controller
{

}
