<?php

require 'vendor/autoload.php';

use League\OAuth2;

$provider = new OAuth2\Client\Provider\GenericProvider([
    'clientId'                => 'RJ6JhG1pzqZjmJn',    // Buscar en http://www.login-sms.com/api-management
    'clientSecret'            => 'GwmeB5IQJUM3ZTS',   // Buscar en http://www.login-sms.com/api-management
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
        'http://api.login-sms.com/messages/send-batch-list',
        $accessToken
    );

    //Agregamos al request el json necesario para enviar un mensaje masivo
    //to_contacts //MAX 500
    $request->getBody()->write(json_encode([
       'content' => 'Test',
            'to_contacts' => [
                [
                    'number' => '5492804324493'
                ],
                [
                    'number' => '5492804324493'
                ]
            ]
    ]));

    $response = $provider->getResponse($request);

    //Mostramos la repuesta de la api
    if ($response->getBody()) {
        echo $response->getBody();
    }

} catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
    exit($e->getMessage());
}
