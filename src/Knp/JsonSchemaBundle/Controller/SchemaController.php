<?php

namespace Knp\JsonSchemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class SchemaController extends Controller
{
    public function showAction($alias)
    {
        $classname = $this->get('json_schema.registry')->get($alias);
        $schema    = $this->get('json_schema.generator')->generate($classname);

        return new JsonResponse($schema);
    }
}
