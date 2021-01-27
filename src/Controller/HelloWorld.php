<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HelloWorld
{
    public function hello(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body><h1>Hello World!</h1>Lucky number: ' . $number . '</body></html>'
        );
    }
}
