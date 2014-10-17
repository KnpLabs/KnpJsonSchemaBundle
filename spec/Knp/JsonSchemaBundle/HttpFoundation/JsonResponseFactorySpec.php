<?php

namespace spec\Knp\JsonSchemaBundle\HttpFoundation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JsonResponseFactorySpec extends ObjectBehavior

{
    /**
     * @param \Knp\JsonSchemaBundle\Schema\SchemaRegistry $registry
     * @param \Symfony\Component\Routing\RouterInterface  $router
     */
    function let($registry, $router)
    {
        $this->beConstructedWith($registry, $router);
    }

    /**
     * @param \stdClass $data
     */
    function it_creates_a_json_response_and_associate_a_json_schema_if_available(
        $registry, $router, $data
    )
    {
        $registry->getAlias(Argument::any())->willReturn('foo');
        $router->generate('show_json_schema', array('alias' => 'foo'), true)->willReturn('http://localhost/schemas/foo.json');

        $response = $this->create($data);
        $response->headers->get('Content-Type')->shouldBe('application/json');
        $response->headers->get('Link')->shouldBe('<http://localhost/schemas/foo.json>; rel="describedBy"');
        $response->shouldHaveType('Symfony\Component\HttpFoundation\JsonResponse');
    }
}
