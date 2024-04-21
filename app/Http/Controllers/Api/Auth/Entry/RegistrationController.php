<?php

namespace App\Http\Controllers\Api\Auth\Entry;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\User\Requests\Entry\RegistrationRequest;

use App\Modules\User\Action\CreatUserAction;

use App\Modules\User\DTO\CreatUserDto;
use App\Services\Auth\AuthService;
use App\Services\Auth\Drivers\AuthJwt;

class RegistrationController extends Controller
{
    protected AuthService $serviceAuth;
    public function __construct()
    {
        $this->serviceAuth = ( new AuthService(new AuthJwt()) );
        // (new AuthService( serviceAuth: (new AuthJwt) ) )->attemptUserAuth()->run();
    }
    public function index(RegistrationRequest $request)
    {

        $validated = $request->validated();
        $token = $this->serviceAuth->attemptUserAuth($request);

        // dd($token);

        //выкидываем ошибку - если у нас прислали email и phone вместе
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
