<?php

namespace spec\Knp\JsonSchemaBundle\HttpFoundation;

use PHPSpec2\ObjectBehavior;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JsonResponseFactory extends ObjectBehavior

{
    /**
     * @param Knp\JsonSchemaBundle\Schema\SchemaRegistry $registry
     * @param Symfony\Component\Routing\RouterInterface  $router
     * @param stdClass                                   $data
     */
    function let($registry, $router, $data)
    {
        $this->beConstructedWith($registry, $router);
    }

    function it_should_create_a_json_response_and_associate_a_json_schema(
        $registry, $router, $data
    )
    {
        $registry->getAlias(ANY_ARGUMENT)->willReturn('foo');
        $router->generate('show_json_schema', ['alias' => 'foo'], true)->willReturn('http://localhost/schemas/foo.json');

        $response = $this->create($data);
        $response->headers->get('Content-Type')->shouldBe('application/foo+schema; profile=http://localhost/schemas/foo.json#');
        $response->headers->get('Link')->shouldBe('<http://localhost/schemas/foo.json#>; rel="describedBy"');
        $response->shouldHaveType('Symfony\Component\HttpFoundation\JsonResponse');
    }

    function it_should_throw_a_not_found_exception_if_alias_is_not_registered(
        $registry, $data
    )
    {
        $registry->getAlias(ANY_ARGUMENT)->willThrow(new \InvalidArgumentException);

        $this->shouldThrow(new NotFoundHttpException)->duringCreate($data);
    }
}
