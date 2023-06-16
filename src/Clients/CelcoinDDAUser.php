<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\DDA\RegisterUser as DDARegisterUser;
use WeDevBr\Celcoin\Rules\DDA\RemoveUser as DDARemoveUser;
use WeDevBr\Celcoin\Types\DDA\RegisterUser;
use WeDevBr\Celcoin\Types\DDA\RemoveUser;

/**
 * Class CelcoinDDAUser
 * A API de subscription permite acesso de forma eletrônica aos boletos emitidos em um determinado CPF ou CNPJ.
 * @package WeDevBr\Celcoin
 */
class CelcoinDDAUser extends CelcoinBaseApi
{
    public function register(RegisterUser $data)
    {
        $body = Validator::validate($data->toArray(), DDARegisterUser::rules());
        return $this->post(
            "/dda-subscription-webservice/v1/subscription/Register",
            $body
        );
    }

    public function remove(RemoveUser $data)
    {
        $body = Validator::validate($data->toArray(), DDARemoveUser::rules());
        return $this->get(
            "dda-subscription-webservice/v1/subscription/Register",
            $body
        );
    }
}