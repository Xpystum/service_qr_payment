<?php

namespace App\Http\Controllers\Swagger\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\GET(
 *
 *     path="/api/terminal/{organization:uuid}",
 *     summary="Вернуть все терминалы по организации",
 *     tags={"Terminal"},
 *     @OA\Parameter(
 *         name="organization:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID организации",
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                @OA\Schema(
 *                    type="object",
 *                    properties={}
 *                )
 *             },
 *         ),
 *     ),
 *
 *      @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array" , @OA\Items(ref="#/components/schemas/TerminalResource")),
 *               @OA\Property(property="message", type="string", example="Get all child terminal of the user"),
 *           ),
 *       ),
 *
 *      @OA\Response(
 *           response=401,
 *           description="Ошибка авторизации.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *           ),
 *       ),
 *
 *      @OA\Response(
 *           response=500,
 *           description="Общая ошибка сервера.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error server"),
 *               @OA\Property(property="code", type="integer", example="500"),
 *           ),
 *      ),
 *
 *      security={
 *          {"bearerAuth": {}}
 *      },
 *
 * ),
 *
 * @OA\POST(
 *
 *     path="/api/terminal/{organization:uuid}",
 *     summary="Создать терминал",
 *     tags={"Terminal"},
 *     @OA\Parameter(
 *         name="organization:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID организации",
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                @OA\Schema(
 *                     type="object",
 *                     properties={
 *                         @OA\Property(property="name", type="string", minLength=3, maxLength=255,
 *                             description="Название терминала, обязательное поле, строка от 3 до 255 символов."),
 *                         @OA\Property(property="organization_uuid", type="string", format="uuid",
 *                             description="UUID организации, обязательное поле.")
 *                     },
 *                     required={"name", "organization_uuid"}
 *                 )
 *             },
 *         ),
 *     ),
 *
 *     @OA\Response(
 *          response=201,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object" , ref="#/components/schemas/TerminalResource"),
 *              @OA\Property(property="message", type="string", example="Successfully create terminal"),
 *          ),
 *     ),
 *
 *      @OA\Response(
 *           response=404,
 *           description="Ошибка создание терминала.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string") , nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed create terminal")
 *           ),
 *      ),
 *
 *      @OA\Response(
 *           response=401,
 *           description="Ошибка авторизации.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *           ),
 *       ),
 *
 *      @OA\Response(
 *           response=500,
 *           description="Общая ошибка сервера.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error server"),
 *               @OA\Property(property="code", type="integer", example="500"),
 *           ),
 *      ),
 *
 *      security={
 *          {"bearerAuth": {}}
 *      },
 *
 * ),
 *
 * @OA\GET(
 *
 *     path="/api/terminal/{terminal:uuid}",
 *     summary="Вернуть терминал по uuid",
 *     tags={"Terminal"},
 *     @OA\Parameter(
 *         name="terminal:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID терминала",
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                @OA\Schema(
 *                     type="object",
 *                     properties={},
 *                 )
 *             },
 *         ),
 *     ),
 *
 *     @OA\Response(
 *          response=201,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object" , ref="#/components/schemas/TerminalResource"),
 *              @OA\Property(property="message", type="string", example="Successfully create terminal"),
 *          ),
 *     ),
 *
 *     @OA\Response(
 *          response=401,
 *          description="Ошибка авторизации.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *          ),
 *     ),
 *
 *      @OA\Response(
 *           response=500,
 *           description="Общая ошибка сервера.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error server"),
 *               @OA\Property(property="code", type="integer", example="500"),
 *           ),
 *      ),
 *
 *      security={
 *          {"bearerAuth": {}}
 *      },
 *
 *
 * ),
 *
 * @OA\Put(
 *      tags={"Terminal"},
 *      path="/api/path/{terminal:uuid}",
 *      summary="Изменить название терминала",
 *      @OA\Parameter(
 *         name="terminal:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID терминала",
 *     ),
 *
 *      @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                @OA\Schema(
 *                     type="object",
 *                     properties={
 *                         @OA\Property(property="name", type="string", minLength=3, maxLength=255,
 *                             description="Название терминала, обязательное поле, строка от 3 до 255 символов."),
 *                     },
 *                     required={"name"}
 *                 )
 *             },
 *         ),
 *      ),
 *
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array", @OA\Items(type="string") , nullable=true),
 *              @OA\Property(property="message", type="string", example="Successfully update terminal"),
 *          ),
 *     ),
 *
 *     @OA\Response(
 *          response=401,
 *          description="Ошибка авторизации.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *          ),
 *     ),
 *
 *      @OA\Response(
 *           response=500,
 *           description="Общая ошибка сервера.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error server"),
 *               @OA\Property(property="code", type="integer", example="500"),
 *           ),
 *      ),
 *
 *      @OA\Response(
 *           response=404,
 *           description="Ошибка обновление терминала.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string") , nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed update terminal")
 *           ),
 *      ),
 * ),
 *
 * @OA\DELETE(
 *      tags={"Terminal"},
 *      path="/api/path/{terminal:uuid}",
 *      summary="Удалить терминал",
 *      @OA\Parameter(
 *         name="terminal:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID терминала",
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array", @OA\Items(type="string") , nullable=true),
 *              @OA\Property(property="message", type="string", example="Terminal deleted"),
 *          ),
 *     ),
 *
 *     @OA\Response(
 *          response=401,
 *          description="Ошибка авторизации.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *          ),
 *     ),
 *
 *      @OA\Response(
 *           response=500,
 *           description="Общая ошибка сервера.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error server"),
 *               @OA\Property(property="code", type="integer", example="500"),
 *           ),
 *      ),
 *
 *      @OA\Response(
 *           response=404,
 *           description="Ошибка обновление терминала.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string") , nullable=true),
 *               @OA\Property(property="message", type="string", example="Terminal failed deleted")
 *           ),
 *      ),
 *
 *
 * ),
 *
 *
 * @OA\Schema(
 *      schema="TerminalResource",
 *      title="Terminal Resource",
 *      type="object",
 *      properties={
 *           @OA\Property(property="name", type="string"),
 *           @OA\Property(property="uuid", type="string"),
 *           @OA\Property(property="organization_uuid", type="string"),
 *      },
 *
 * ),
 *
 *
 *
 *
 *
 */

class TerminalController extends Controller
{
    //
}
