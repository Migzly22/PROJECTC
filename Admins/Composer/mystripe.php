<?php

require __DIR__."/vendor/autoload.php";

$stripe_secret_key = "sk_test_51ODykbHBsWbalG1Mmn5uvnp3i7wWqLmcpR9aCzI6xPgsHYT6ZVoQqj1bvbf1x4iRL8MFO2S8lxmDNeudzM6hBDzG00WmVKs3lt";

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create(
    [
        "mode" => "payment",
        "success_url" => "http://localhost/PROJECTC/Admins/Composer/mystripe.php",
        "line_items" => [
            [
                "quantity" => 1,
                "price_data" => [
                    "currency"=>"php",
                    "unit_amount" => 200000,
                    "product_data" =>[
                        "name" => "Down payment"
                    ]
                ]
            ]
        ]
    ]
);

http_response_code(303);
header("Location: ".$checkout_session->url);