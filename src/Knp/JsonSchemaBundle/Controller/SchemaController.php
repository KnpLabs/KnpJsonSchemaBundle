<?php

namespace Knp\JsonSchemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\JsonSchemaBundle\Model\Schema;

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
        $schema   = $this->get('json_schema.generator')->generate($alias);
        $response = $this->get('json_schema.response.factory')->create($schema, 'json', Schema::SCHEMA_LATEST);

        return $response;
    }
}
