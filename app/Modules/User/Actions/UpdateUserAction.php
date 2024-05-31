<?php

namespace App\Modules\User\Actions;

use App\Modules\User\DTO\UpdateUserDTO;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateUserAction
{
    public static function run(UpdateUserDTO $data) : User
    {
        $user = User::find($data->id);
        // $attributesToUpdate = $data->filterIsNotNull();

        try {

            //кринж ситуатция с повторным обновлением полей =) - но что бы сделать быстрее #TODO потом переделать
            $user = $user->updateOrFail(
                [
                    'email' => $data->email ?? $user->email,
                    'phone' => $data->phone ?? $user->phone,

                    'first_name' => $data->first_name ?? $user->first_name,
                    'last_name' => $data->last_name ?? $user->last_name,
                    'father_name' => $data->father_name ?? $user->father_name,

                    'email_confirmed_at' => $user->email ? null : $user->email_confirmed_at,
                    'phone_confirmed_at' => $user->email ? null : $user->phone_confirmed_at,
                ]
            );

            // $user = $user->updateOrFail($attributesToUpdate);

        } catch (\Throwable $e) {

            // Запись ошибки в лог
            Log::error('Ошибка при обновлении пользователя: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'attributes' => [
                    'email' => $data->email,
                    'phone' => $data->phone,

                    'first_name' => $data->first_name,
                    'last_name' => $data->last_name,
                    'father_name' => $data->father_name,
                ]
            ]);

            // Обработка ошибки, например, возврат ответа с ошибкой
            return response()->json(['message' => 'Произошла ошибка при обновлении пользователя'], 500);
        }


        if(!$user->save()){
            throw new ModelNotFoundException('Не удалось создать пользователя.', 500);
        }


        return $user;
    }

}
