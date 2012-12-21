<?php

namespace Knp\JsonSchemaBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\JsonSchemaBundle\Model\Schema;

class JsonSchemaResponse extends JsonResponse
{
    public function __construct(Schema $data)
    {
        parent::__construct('', 200, ['Content-Type' => 'application/json+schema']);

        $this->setData($data);
    }
}
