<?php

namespace spec\Knp\JsonSchemaBundle\HttpFoundation;

use PHPSpec2\ObjectBehavior;

class JsonSchemaResponse extends ObjectBehavior
{
    function it_should_be_a_json_response()
    {
        $this->shouldHaveType('Symfony\Component\HttpFoundation\JsonResponse');
    }

    /**
     * @param Symfony\Component\HttpFoundation\HeaderBar $headers
     */
    function its_content_type_should_be_the_json_schema_mimetype($headers)
    {
        $this->headers = $headers;
        $headers->set('Content-Type', 'application/json+schema')->shouldBeCalled();
    }
}
