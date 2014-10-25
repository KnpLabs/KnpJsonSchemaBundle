<?php

namespace Knp\JsonSchemaBundle\Controller;

use Knp\JsonSchemaBundle\Schema\SchemaRegistry;
use Knp\JsonSchemaBundle\Schema\SchemaGenerator;
use Symfony\Component\Routing\RouterInterface;
use Knp\JsonSchemaBundle\HttpFoundation\JsonSchemaResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class SchemaController
{
    /**
     * @var SchemaRegistry
     */
    protected $schemaRegistry;

    /**
     * @var SchemaGenerator
     */
    protected $schemaGenerator;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param SchemaRegistry $schemaRegistry
     * @param SchemaGenerator $schemaGenerator
     * @param RouterInterface $router
     */
    public function __construct(
        SchemaRegistry $schemaRegistry,
        SchemaGenerator $schemaGenerator,
        RouterInterface $router
    ) {
        $this->schemaRegistry = $schemaRegistry;
        $this->schemaGenerator = $schemaGenerator;
        $this->router = $router;
    }

    public function indexAction()
    {
        $data = array();
        foreach ($this->schemaRegistry->getAliases() as $alias) {
            $data[$alias.'_url'] = $this->router->generate('show_json_schema', array('alias' => $alias), true);
        }

        return new JsonResponse($data);
    }

    public function showAction($alias)
    {
        $schema = $this->schemaGenerator->generate($alias);

        return new JsonSchemaResponse($schema, $alias, 'http://json-schema.org/schema');
    }
}
