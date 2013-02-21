<?php

namespace Knp\JsonSchemaBundle\HttpFoundation;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\JsonSchemaBundle\Schema\SchemaRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JsonResponseFactory
{
    public function __construct(SchemaRegistry $registry, RouterInterface $router)
    {
        $this->registry = $registry;
        $this->router   = $router;
    }

    public function create($data, $alias = null, $route = null)
    {
        try {
            $alias = $alias ?: $this->registry->getAlias(get_class($data));
        } catch (\InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        }
        $route = sprintf('%s#', $route ?: $this->router->generate('show_json_schema', ['alias' => $alias], true));

        return new JsonResponse($data, 200, [
            'Content-Type' => sprintf('application/%s+json; profile=%s', $alias, $route),
            'Link'         => sprintf('<%s>; rel="describedBy"', $route),
        ]);
    }
}
