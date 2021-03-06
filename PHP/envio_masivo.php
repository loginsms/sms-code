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

    //Armamos el request para enviar un sms simple
    $request = $provider->getAuthenticatedRequest(
        'POST',
        'http://api.login-sms.com/messages/send-batch',
        $accessToken
    );

    //Agregamos al request el json necesario para enviar un mensaje masivo
    $request->getBody()->write(json_encode([
        'contact_group_id' => '7',
        'content' => 'Prueba masiva de api'
    ]));

    $response = $provider->getResponse($request);

    //Mostramos la repuesta de la api
    if ($response->getBody()) {
        echo $response->getBody();
    }

} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
    exit($e->getMessage());
}
