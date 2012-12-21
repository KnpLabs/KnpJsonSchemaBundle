<?php

namespace Knp\JsonSchemaBundle\HttpFoundation;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonSchemaResponse extends JsonResponse
{
    public function __construct($data, $alias, $route)
    {
        parent::__construct('', 200, [
            'Content-Type' => sprintf('application/%s+schema', $alias),
            'Link'         => sprintf('<%s>; rel="describedBy"', $route),
        ]);

        $this->setData($data);
    }
}
