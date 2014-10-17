<?php

namespace spec\Knp\JsonSchemaBundle\Property;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FormTypeGuesserHandlerSpec extends ObjectBehavior
{
    /**
     * @param \Symfony\Component\Form\FormTypeGuesserInterface $guesser
     * @param \Knp\JsonSchemaBundle\Schema\SchemaRegistry $schemaRegistry
     * @param \Knp\JsonSchemaBundle\Model\Property $property
     * @param \Symfony\Component\Form\Guess\TypeGuess $typeGuess
     * @param \Symfony\Component\Form\Guess\ValueGuess $requiredGuess
     * @param \Symfony\Component\Form\Guess\ValueGuess $patternGuess
     * @param \Symfony\Component\Form\Guess\ValueGuess $maxLengthGuess
     */
    function let($guesser, $schemaRegistry, $property, $typeGuess, $requiredGuess, $patternGuess, $maxLengthGuess)
    {
        $this->beConstructedWith($guesser, $schemaRegistry);
        $guesser->guessType(Argument::any(), null)->shouldBeCalled()->willReturn($typeGuess);
        $guesser->guessRequired(Argument::any(), null)->shouldBeCalled()->willReturn($requiredGuess);
        $guesser->guessPattern(Argument::any(), null)->shouldBeCalled()->willReturn($patternGuess);
        $guesser->guessMaxLength(Argument::any(), null)->shouldBeCalled()->willReturn($maxLengthGuess);
    }

    function it_adds_json_type_object_if_guessed_type_is_entity($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('entity');
        $typeGuess->getOptions()->shouldBeCalled();
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('object')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_array_if_guessed_type_is_collection($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('collection');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('array')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_boolean_if_guessed_type_is_checkbox($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('checkbox');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('boolean')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_number_if_guessed_type_is_number($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('number');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('number')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_integer_if_guessed_type_is_integer($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('integer');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('integer')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_date($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('date');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat('date')->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_datetime($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('datetime');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat('date-time')->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_text($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('text');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_country($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('country');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_email($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('email');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_file($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('file');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_language($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('language');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_locale($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('locale');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_time($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('time');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat("time")->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_adds_json_type_string_if_guessed_type_is_url($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('url');
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->addType('string')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_sets_json_format_date_time_if_guessed_type_is_datetime($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('datetime');
        $property->addType("string")->shouldBeCalled();
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(\Knp\JsonSchemaBundle\Model\Property::FORMAT_DATETIME)->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_sets_json_format_date_if_guessed_type_is_date($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('date');
        $property->addType("string")->shouldBeCalled();
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(\Knp\JsonSchemaBundle\Model\Property::FORMAT_DATE)->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_sets_json_format_time_if_guessed_type_is_time($guesser, $property, $typeGuess)
    {
        $typeGuess->getType()->willReturn('time');
        $property->addType("string")->shouldBeCalled();
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setFormat(\Knp\JsonSchemaBundle\Model\Property::FORMAT_TIME)->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_sets_a_property_requirement_if_guessed_requirement_is_true($guesser, $property, $requiredGuess)
    {
        $requiredGuess->getValue()->willReturn(true);
        $property->addType(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(true)->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_sets_a_property_non_requirement_if_guessed_requirement_is_false($guesser, $property, $requiredGuess)
    {
        $requiredGuess->getValue()->willReturn(false);
        $property->addType(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->setRequired(false)->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_sets_a_json_pattern_if_guessed_pattern_is_not_null($guesser, $property, $patternGuess)
    {
        $patternGuess->getValue()->willReturn('/^[a-z]{5}$/');
        $property->addType(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setMaximum(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setPattern('/^[a-z]{5}$/')->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }

    function it_sets_a_maximum_if_guessed_maximum_length_is_not_null($guesser, $property, $maxLengthGuess)
    {
        $maxLengthGuess->getValue()->willReturn(10);
        $property->addType(null)->shouldBeCalled();
        $property->setFormat(null)->shouldBeCalled();
        $property->setRequired(null)->shouldBeCalled();
        $property->setPattern(null)->shouldBeCalled();
        $property->getTitle()->shouldBeCalled();
        $property->setTitle("")->shouldBeCalled();
        $property->getName()->shouldBeCalled();
        $property->setMaximum(10)->shouldBeCalled();

        $this->handle('my\class\namespace', $property);
    }
}
