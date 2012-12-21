<?php

namespace Knp\JsonSchemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\JsonSchemaBundle\HttpFoundation\JsonSchemaResponse;

class SchemaController extends Controller
{
    public function showAction($alias)
    {
        $namespace = $this->get('json_schema.registry')->getNamespace($alias);
        $schema    = $this->get('json_schema.generator')->generate($namespace);

        return new JsonSchemaResponse($schema, $alias, 'http://json-schema.org/schema');
    }
}
