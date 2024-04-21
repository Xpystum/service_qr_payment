<?php


namespace App\Http\Controllers\Api\Auth\Entry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\User\Requests\Entry\RegistrationRequest;

use App\Modules\User\Action\CreatUserAction;

use App\Modules\User\DTO\CreatUserDto;
use App\Services\Auth\AuthService;
use App\Services\Auth\Drivers\AuthJwt;



class LoginController extends Controller
{

    protected AuthService $serviceAuth;
    public function __construct()
    {
        $this->serviceAuth = ( new AuthService(new AuthJwt()) );
        // (new AuthService( serviceAuth: (new AuthJwt) ) )->attemptUserAuth()->run();
    }
    public function index()
    {
        return 2;
    }
}
