<?php

require 'vendor/autoload.php';

use League\OAuth2;

$provider = new OAuth2\Client\Provider\GenericProvider([
    'clientId'                => 'CLIENT_ID',    // Buscar en http://www.login-sms.com/api-management
    'clientSecret'            => 'CLIENT_SECRET',   // Buscar en http://www.login-sms.com/api-management
    'redirectUri'             => 'http://example.com/your-redirect-url/',
    'urlAuthorize'            => '',
    'urlAccessToken'          => 'http://api.login-sms.com/token',
    'urlResourceOwnerDetails' => ''
]);

try {
    //Obtenemos el token
    $accessToken = $provider->getAccessToken('client_credentials');

    echo 'Access Token: ' . $accessToken->getToken() . "<br>";
    echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
    echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
    echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

    //Armamos el request a la url de la api que deseemos
    $request = $provider->getAuthenticatedRequest(
        'GET',
        'http://api.login-sms.com/contacts-groups',
        $accessToken
    );

    $response = $provider->getResponse($request);

    //Mostramos la repuesta de la api
    if ($response->getBody()) {
        echo $response->getBody();
    }

} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
    exit($e->getMessage());
}
