<?php

namespace App\Http\Controllers;
use MercadoPago;

final class MercadoHandler
{
	const SANDBOX_CLIENT_ID = "8165552372634154";
    const SANDBOX_CLIENT_SECRET = "EKzGVQzDTAEclfi6abTOBe3mc1DQ3J6A";
    const SANDBOX_ACCESS_TOKEN = "APP_USR-8165552372634154-032118-219f451f278a1bc962f0b9809ca88b5e-418906657";

    const CLIENT_ID = "4757717842404032";
    const CLIENT_SECRET = "2Y4pmHzCwJPoS9tTpXjLYIFnUtFYb8i7";
    const ACCESS_TOKEN = "APP_USR-4757717842404032-031710-9406a351eb88dc4a26a777de58eeb715-203380971";
    const IS_SANDBOX = true;

    public static function authClient()
    {
    	MercadoPago\SDK::setClientId(self::IS_SANDBOX ? self::SANDBOX_CLIENT_ID : self::CLIENT_ID);
        MercadoPago\SDK::setClientSecret(self::IS_SANDBOX ? self::SANDBOX_CLIENT_SECRET : self::CLIENT_SECRET);
    }

    public static function authAccess()
    {
    	MercadoPago\SDK::setAccessToken(self::IS_SANDBOX ? self::SANDBOX_ACCESS_TOKEN : self::ACCESS_TOKEN);
    }
}