<?php

namespace Knp\JsonSchemaBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonSchemaResponse extends JsonResponse
{
    protected function update()
    {
        $this->headers->set('Content-Type', 'application/json+schema');
    }
}
