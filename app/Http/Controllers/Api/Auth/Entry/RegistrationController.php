<?php

namespace App\Http\Controllers\Api\Auth\Entry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\User\Requests\Entry\RegistrationRequest;

use App\Modules\User\Action\CreatUserAction;

use App\Modules\User\DTO\CreatUserDto;

class RegistrationController extends Controller
{
    public function index(RegistrationRequest $request)
    {

        $validated = $request->validated();

        //выкидываем ошибку - если у нас прислали email и phone
        abort_if( !isset($validated['email']) && !isset($validated['phone']) , 400, 'Only Email or Phone');

        $user = (new CreatUserAction)->run(

            new CreatUserDto(

                email: isset($validated['email']) ? $validated['email'] : null,

                phone: isset($validated['phone']) ? $validated['phone'] : null,

                password: $request->password,

            )

        );

        dd($user);



        // $validated = $request->validated();

        // if(isset($validated['email']) || isset($validated['phone'])){

        //     $data = new CreatUserDto(

        //         email: $validated?->email,

        //         phone: $validated?->phone,

        //         password: $validated['email'],

        //     );

        // }



        // dd(filter_var($request->input('entry'), FILTER_VALIDATE_EMAIL));
        // RegistrationRequest $request
        return 'зашли в регистер';
    }
}
