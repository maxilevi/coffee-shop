<?php

namespace App\Http\Controllers;
use MercadoPago;

final class MercadoHandler
{
	const SANDBOX_CLIENT_ID = "";
    const SANDBOX_CLIENT_SECRET = "";
    const SANDBOX_ACCESS_TOKEN = "";

    const CLIENT_ID = "";
    const CLIENT_SECRET = "";
    const ACCESS_TOKEN = "";
    const IS_SANDBOX = false;

    public static function authClient()
    {
    	MercadoPago\SDK::setClientId(self::IS_SANDBOX ? self::SANDBOX_CLIENT_ID : self::CLIENT_ID);
        MercadoPago\SDK::setClientSecret(self::IS_SANDBOX ? self::SANDBOX_CLIENT_SECRET : self::CLIENT_SECRET);
    }

    public static function authAccess()
    {
    	MercadoPago\SDK::setAccessToken(self::getAccessToken());
    }

    public static function getAccessToken()
    {
    	return self::IS_SANDBOX ? self::SANDBOX_ACCESS_TOKEN : self::ACCESS_TOKEN;
    }
}
