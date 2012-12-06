**This bundle is in development stage!!! Do not use it in production.**
[![Build Status](https://secure.travis-ci.org/KnpLabs/KnpJsonSchemaBundle.png)](https://travis-ci.org/KnpLabs/KnpJsonSchemaBundle)

The JsonSchema Bundle
=====================

The purpose of this bundle is to provide a service which allow you to generate json schema based on validation metadata.

If the question is about the purpose of Json schema, well, I can only advise you to take a look at the official website: http://json-schema.org/

Installation
------------
Add the following to your composer.json:
``` json
{
    "mininmum-stability": "dev",
    "require": {
        "knplabs/json-schema-bundle": "dev-master"
    }
}
```

and run `composer.phar update knplabs/json-schema-bundle`

Usage
-----
``` php
public function indexAction()
{
    $json = $this->get('json_schema.generator')->generate('App\\Entity\\User');

    return new JsonResponse($json);
}
```

Internals
---------
It uses the Validator and Doctrine FormTypeGuesser to guess values of 'required', 'type', 'pattern', 'minLength' and 'maxLength'.

For property that couldn't be guessed with these guessers, another handler take over from it.

Currently, this property constraints are also supported:
    - `Symfony\Component\Validator\Constraints\Choice`
    - `Symfony\Component\Validator\Constraints\Length` (especially for the `min` constraint)

Examples
--------
``` gerhkin
    Feature: Generate a json schema from an object metada
        As a hatoas lover
        In order to acquire the power of json schema
        I need to generate it from an object metadata

        Scenario: Do all the stuff!!
            Given the following class:
                """
                <?php

                namespace App\Entity;

                use Symfony\Component\Validator\Constraints as Assert;

                use Doctrine\ORM\Mapping as ORM;

                /**
                 * @ORM\Entity
                 **/
                class User
                {
                    /**
                     * @ORM\Id
                     * @ORM\Column(type="integer")
                     * @ORM\GeneratedValue(strategy="AUTO")
                     */
                    protected $id;

                    /**
                     * @ORM\Column(type="string", nullable=false)
                     */
                    protected $name;

                    /**
                     * @Assert\Type(type="string")
                     * @Assert\Email()
                     * @Assert\NotBlank()
                     */
                    protected $email;

                    /**
                     * @Assert\Regex(pattern="/^[0-9]{5}$/")
                     */
                    protected $zipCode;

                    /**
                     * @Assert\Length(min="2", max="50")
                     */
                    protected $address;

                    /**
                     * @ORM\Column(type="integer")
                     * @Assert\Length(min="21")
                     */
                    protected $age;

                    /**
                     * @Assert\Blank()
                     */
                    protected $file;

                    /**
                     * @Assert\Choice(choices={"toto","tutu","tata"})
                     */
                    protected $type;

                    /**
                     * @ORM\Column(type="decimal", nullable=true)
                     */
                    protected $balance;
                }
                """
            When I generate the json schema
            Then I WILL get the following json:
                """
                {
                    "title": "user",
                        "properties": {
                            "id": {
                                "required": true,
                                "type": "integer"
                            },
                            "name": {
                                "required": true,
                                "type": "string"
                            },
                            "email": {
                                "required": true,
                                "type": "string"
                            },
                            "zipCode": {
                                "required": false,
                                "type": "string",
                                "pattern": "[0-9]{5
                            }"
                            },
                            "address": {
                                "required": false,
                                "type": "string",
                                "minLength": "2",
                                "maxLength": "50"
                            },
                            "age": {
                                "required": true,
                                "type": "integer",
                                "minimum": "21"
                            },
                            "file": {
                                "required": false,
                                "type": "string"
                            },
                            "type": {
                                "required": false,
                                "type": "string",
                                "enum": [
                                    "toto",
                                    "tutu",
                                    "tata"
                                ]
                            },
                            "balance": {
                                "required": false,
                                "type": "number"
                            }
                        }
                }
                """
```

Contributors
------------
 - Gildas Quéméner [gquemener](https://github.com/gquemener)
 - Florian Klein [docteurklein](https://github.com/docteurklein)
