<?php

return [
    //Configuracion de la LTI 1.3 para la plataforma
    'lti13' => [
        'signature_method' => env('LTI13_SIGNATURE_METHOD', 'RS256'),
        'key_id' => env('LTI13_KEY_ID', 'key-1'),
        // LTI 1.3 keys
        'rsa_public_key' => env('LTI13_RSA_PUBLIC_KEY'),
        'rsa_private_key' => env('LTI13_RSA_PRIVATE_KEY'),
        'auto_register_deployment_id' => env('LTI13_AUTO_REGISTER_DEPLOYMENT_ID', false),
        'required_scopes' => [
            // sample scope URLs
            //"https://purl.imsglobal.org/spec/lti-ags/scope/lineitem",
            //"https://purl.imsglobal.org/spec/lti-ags/scope/result.readonly",
            //"https://purl.imsglobal.org/spec/lti-ags/scope/score",
            //"https://purl.imsglobal.org/spec/lti-nrps/scope/contextmembership.readonly",
        ]
    ],

];