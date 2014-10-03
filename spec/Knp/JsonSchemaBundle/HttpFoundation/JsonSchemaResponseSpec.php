<?php

namespace spec\Knp\JsonSchemaBundle\HttpFoundation;

use PhpSpec\ObjectBehavior;

class JsonSchemaResponseSpec extends ObjectBehavior
{
    /**
     * @param \Knp\JsonSchemaBundle\Model\Schema $schema
     */
    public function let($schema)
    {
        $this->beConstructedWith($schema, 'palourde', 'the/schema/route');
    }

    function it_is_a_json_response()
    {
        $this->shouldHaveType('Symfony\Component\HttpFoundation\JsonResponse');
    }

    function its_content_type_is_the_json_schema_mimetype()
    {
        $this->headers->get('Content-Type')->shouldReturn('application/palourde+json');
    }

    function its_described_by_the_core_json_schema()
    {
        $this->headers->get('Link')->shouldReturn('<the/schema/route>; rel="describedBy"');
    }
}
