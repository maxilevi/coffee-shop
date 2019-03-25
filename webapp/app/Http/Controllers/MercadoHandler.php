<?php

namespace App\Http\Controllers;
use MercadoPago;

final class MercadoHandler
{
	const SANDBOX_CLIENT_ID = "5051127679424173";
    const SANDBOX_CLIENT_SECRET = "sMzYtyIhfP7n6ziInVamzLO9QESZmzFE";
    const SANDBOX_ACCESS_TOKEN = "APP_USR-5051127679424173-032313-e8571eaaaf2a57b65e29b6d8f95bc4b7-419352486";

    const CLIENT_ID = "4757717842404032";
    const CLIENT_SECRET = "2Y4pmHzCwJPoS9tTpXjLYIFnUtFYb8i7";
    const ACCESS_TOKEN = "APP_USR-4757717842404032-031710-9406a351eb88dc4a26a777de58eeb715-203380971";
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