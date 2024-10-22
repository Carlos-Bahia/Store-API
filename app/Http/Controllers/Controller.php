<?php

namespace App\Http\Controllers;

/**
    * @OA\Info(
    * title="API de Produtos",
    * version="1.0.0",
    * description="API para gerenciamento de produtos."
    * ),
    * @OA\SecurityScheme(
    * securityScheme="bearerAuth",
    * in="header",
    * name="bearerAuth",
    * type="http",
    * scheme="bearer",
    * bearerFormat="JWT",
    * ),
 */
abstract class Controller
{
    //
}
