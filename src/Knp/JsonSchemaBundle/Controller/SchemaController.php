<?php

namespace Knp\JsonSchemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\JsonSchemaBundle\HttpFoundation\JsonSchemaResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class SchemaController extends Controller
{
    public function indexAction()
    {
        $data = array();
        foreach ($this->get('json_schema.registry')->getAliases() as $alias) {
            $data[$alias.'_url'] = $this->get('router')->generate('show_json_schema', array('alias' => $alias), true);
        }

        return new JsonResponse($data);
    }

    public function showAction($alias)
    {
        $schema = $this->get('json_schema.generator')->generate($alias);

        return new JsonSchemaResponse($schema, $alias, 'http://json-schema.org/schema');
    }
}
