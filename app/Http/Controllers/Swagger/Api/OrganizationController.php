<?php

namespace App\Http\Controllers\Swagger\API;
use App\Http\Controllers\Controller;

/**
 * @OA\GET(
 *
 *      path="/api/organization",
 *      summary="Вернуть все организации у user",
 *      tags={"Organization"},
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
 *               @OA\Property(property="data", type="array" , @OA\Items(ref="#/components/schemas/OrganizationResource")),
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
 * ),
 *

 *
 * @OA\GET(
 *
 *     path="/api/organization/{organization:uuid}",
 *     summary="Вернуть все организации у user",
 *     tags={"Organization"},
 *     @OA\Parameter(
 *         name="organization:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID организации"
 *     ),
 *
 *     @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                     type="object",
 *                     properties={}
 *                 )
 *              },
 *          ),
 *      ),
 *
 *      @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/OrganizationResource"),
 *               @OA\Property(property="message", type="string", example="Return organization"),
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
 *  @OA\POST(
 *
 *     path="/api/organization",
 *     summary="Создать организацию",
 *     tags={"Organization"},
 *
 *     @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                     type="object",
 *                     properties={
 *                          @OA\Property(property="name", type="string", maxLength=101, minLength=2, description="Название организации"),
 *                          @OA\Property(property="address", type="string", maxLength=255, minLength=12, description="Адрес организации"),
 *                          @OA\Property(property="phone_number", type="string", description="Номер телефона"),
 *                          @OA\Property(property="email", type="string", format="email", maxLength=100, description="Электронная почта"),
 *                          @OA\Property(property="website", type="string", description="Веб-сайт"),
 *                          @OA\Property(property="type", type="string", enum={"ooo", "ip"}, description="Тип организации"),
 *                          @OA\Property(property="description", type="string", nullable=true, description="Описание"),
 *                          @OA\Property(property="industry", type="string", nullable=true, description="Отрасль"),
 *                          @OA\Property(property="founded_date", type="string", format="date", nullable=true, description="Дата основания"),
 *                          @OA\Property(property="inn", type="string", description="ИНН организации"),
 *                          @OA\Property(property="kpp", type="string", nullable=true, description="КПП (только для ООО)", example="123456789"),
 *                          @OA\Property(property="registration_number", type="string", nullable=true, description="Регистрационный номер (только для ООО)", example="1234567890123"),
 *                          @OA\Property(property="registration_number_individual", type="string", nullable=true, description="Регистрационный номер (только для ИП)", example="123456789012345"),
 *                     }
 *                 )
 *              },
 *          ),
 *      ),
 *
 *      @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , ref="#/components/schemas/OrganizationResource"),
 *               @OA\Property(property="message", type="string", example="Return organization"),
 *           ),
 *       ),
 *
 *      @OA\Response(
 *           response=401,
 *           description="Ошибка авторизации.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Не авторизован."),
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
 *      ),
 *
 *      @OA\Response(
 *           response=404,
 *           description="Ошибка создание организации",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string"), nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed create organization"),
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
 * @OA\PUT(
 *
 *     path="/api/organization/{organization:uuid}",
 *     summary="Создать организацию",
 *     tags={"Organization"},
 *     @OA\Parameter(
 *         name="organization:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID организации"
 *     ),
 *
 *     @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                     type="object",
 *                     properties={
 *                          @OA\Property(property="name", type="string", maxLength=101, minLength=2, example="Название организации"),
 *                          @OA\Property(property="address", type="string", maxLength=255, minLength=12, example="Адрес организации"),
 *                          @OA\Property(property="phone_number", type="string", example="+79991234567"),
 *                          @OA\Property(property="website", type="string", example="https://example.com"),
 *                          @OA\Property(property="type", type="string", enum={"ooo", "ip"}, example="ooo"),
 *                          @OA\Property(property="description", type="string", example="Описание организации"),
 *                          @OA\Property(property="industry", type="string", example="Отрасль"),
 *                          @OA\Property(property="founded_date", type="string", format="date", example="2000-01-01"),
 *                          @OA\Property(property="inn", type="string", pattern="^(([0-9]{12})|([0-9]{10}))?$", example="1234567890"),
 *                          @OA\Property(property="kpp", type="string", pattern="^(([0-9]{12})|([0-9]{10}))?$", example="123456789"),
 *                          @OA\Property(property="registration_number", type="string", pattern="^([0-9]{13})?$", example="1234567890123"),
 *                          @OA\Property(property="registration_number_individual", type="string", pattern="^\d{15}$", example="123456789012345"),
 *                     },
 *                 ),
 *              }
 *          ),
 *      ),
 *
 *      @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , nullable=true),
 *               @OA\Property(property="message", type="string", example="Successfully update organization"),
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
 *      @OA\Response(
 *           response=404,
 *           description="Ошибка обновление данных организации",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string") , nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed update organization")
 *           ),
 *      ),
 *
 *      security={
 *          {"bearerAuth": {}}
 *      },
 *
 * ),
 *
 * @OA\DELETE(
 *
 *     path="/api/organization/{organization:uuid}",
 *     summary="Вернуть все организации у user",
 *     tags={"Organization"},
 *     @OA\Parameter(
 *         name="organization:uuid",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="uuid"),
 *         description="UUID организации"
 *     ),
 *
 *       @OA\Response(
 *           response=200,
 *           description="Ok",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="object" , nullable=true),
 *               @OA\Property(property="message", type="string", example="Successfully deleted organization"),
 *           ),
 *       ),
 *
 *      @OA\Response(
 *           response=401,
 *           description="Ошибка получения токена.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Ошибка получения токена."),
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
 *      ),
 *
 *      @OA\Response(
 *           response=404,
 *           description="Ошибка удаление данных организации, возможно например когда user, не вляется owner",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(type="string") , nullable=true),
 *               @OA\Property(property="message", type="string", example="Failed deleted organization")
 *           ),
 *      ),
 *
 *      security={
 *          {"bearerAuth": {}}
 *      },
 *
 * ),
 *
 * @OA\Schema(
 *      schema="OrganizationResource",
 *      title="Organization Resource",
 *      type="object",
 *      properties={
 *          @OA\Property(property="uuid", type="string", format="uuid", description="Уникальный идентификатор организации"),
 *          @OA\Property(property="name", type="string", description="Название организации"),
 *          @OA\Property(property="owner_id", type="string", format="uuid", description="Идентификатор владельца"),
 *          @OA\Property(property="address", type="string", description="Адрес организации"),
 *          @OA\Property(property="phone_number", type="string", description="Номер телефона"),
 *          @OA\Property(property="email", type="string", format="email", description="Электронная почта"),
 *          @OA\Property(property="website", type="string", description="Веб-сайт"),
 *          @OA\Property(property="type", type="string", description="Тип организации"),
 *          @OA\Property(property="description", type="string", description="Описание организации", nullable=true),
 *          @OA\Property(property="industry", type="string", description="Отрасль" , nullable=true),
 *          @OA\Property(property="founded_date", type="string", format="date", description="Дата основания", nullable=true),
 *          @OA\Property(property="inn", type="string", description="ИНН"),
 *          @OA\Property(property="kpp", type="string", description="КПП - Если тип ооо, добавляем к правилам валидации kpp и ogrn"),
 *          @OA\Property(property="ogrn", type="string", description="ОГРН - Если тип ооо, добавляем к правилам валидации kpp и ogrn"),
 *          @OA\Property(property="registration_number_individual", type="string", description="Регистрационный номер для ИП - Если тип ИП, добавляем к правилам валидации огрнип (registration_number_individual)" ),
 *
 *      },
 *
 * ),
 *
 *
 */


class OrganizationController extends Controller
{


}
