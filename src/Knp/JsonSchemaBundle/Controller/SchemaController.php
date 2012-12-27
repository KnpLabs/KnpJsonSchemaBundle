<?php

namespace Knp\JsonSchemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\JsonSchemaBundle\HttpFoundation\JsonSchemaResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class SchemaController extends Controller
{
    public function indexAction()
    {
        $data = [];
        foreach ($this->get('json_schema.registry')->getAliases() as $alias) {
            $data[$alias.'_url'] = $this->get('router')->generate('show_json_schema', ['alias' => $alias], true);
        }

        return new JsonResponse($data);
    }

    public function showAction($alias)
    {
        $namespace = $this->get('json_schema.registry')->getNamespace($alias);
        $schema    = $this->get('json_schema.generator')->generate($namespace);

        return new JsonSchemaResponse($schema, $alias, 'http://json-schema.org/schema');
    }
}
