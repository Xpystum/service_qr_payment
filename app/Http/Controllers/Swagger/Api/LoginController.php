<?php


namespace App\Http\Controllers\Api\Auth\Entry;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *
 *      path="/api/login",
 *      summary="вернуть токен для user по email/phone и password",
 *      tags={"Login\Registration"},
 *
 *       @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email_or_password", "password"},
 *              @OA\Property(
 *                 property="email_or_password",
 *                 type="object",
 *                 oneOf={
 *                     @OA\Schema(
 *                         @OA\Property(property="email", type="string", format="email", description="User's email address" example="test@gmail.com")
 *                     ),
 *                     @OA\Schema(
 *                         @OA\Property(property="phone", type="string", description="User's phone number", example="+79200264425", pattern="^\+?[0-9]{1,3}[0-9]{9}$"),
 *                     ),
 *                 }
 *             ),
 *            @OA\Property(property="password", type="string", format="password", description="User's password"),
 *
 *          },
 *
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\JsonContent(
 *              @OA\Property(property="data", ref="#/components/schemas/BearerToken"),
 *              @OA\Property(property="message", type="string", example="Successfully return user"),
 *          )
 *      ),
 *
 * ),
 *
 *
 *
 *
 *
 */

class LoginController extends Controller
{

}
