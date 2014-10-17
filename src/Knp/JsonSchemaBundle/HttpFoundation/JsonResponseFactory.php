<?php

namespace Knp\JsonSchemaBundle\HttpFoundation;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\JsonSchemaBundle\Schema\SchemaRegistry;

class JsonResponseFactory
{
    public function __construct(SchemaRegistry $registry, RouterInterface $router)
    {
        $this->registry = $registry;
        $this->router   = $router;
    }

    public function create($data)
    {
        $headers = array();

        try {
            $alias = $this->registry->getAlias(get_class($data));
            $headers['Link'] = sprintf(
                '<%s>; rel="describedBy"',
                $this->router->generate('show_json_schema', array('alias' => $alias), true)
            );
        } catch (\Exception $e) {
        }

        return new JsonResponse($data, 200, $headers);
    }
}
