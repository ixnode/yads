<?php

namespace App\Validator;

use App\Entity\Document;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use JsonSchema\Validator;

/**
 * Class DocumentValidator
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Validator
 */
class DocumentValidator
{
    /**
     * Function to validate given Document object.
     *
     * @param Document $object
     * @param ExecutionContextInterface $context
     * @return void
     */
    public static function validate(Document $object, ExecutionContextInterface $context): void
    {
        /* Get data */
        $data = (object)$object->getData();

        /* Get schema */
        $schema = (object)$object->getDocumentType()->getAllowedAttributes();

        /* do the schema validation */
        $validator = new Validator();
        $validator->validate($data, $schema);

        if (!$validator->isValid()) {

            foreach ($validator->getErrors() as $error) {
                $context->buildViolation($error['message'])
                    ->atPath('data')
                    ->setCode('422')
                    ->addViolation();
            }
        }
    }
}
