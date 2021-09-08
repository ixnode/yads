<?php declare(strict_types=1);

/*
 * MIT License
 *
 * Copyright (c) 2021 Björn Hempel <bjoern@hempel.li>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace App\Validator;

use App\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
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
     * Returns the request method
     *
     * @todo Fix me. This is a workaround.
     * @return string
     */
    public static function getRequestMethod(): string
    {
        return array_key_exists('REQUEST_METHOD', $_SERVER) ? strtoupper($_SERVER['REQUEST_METHOD']) : Request::METHOD_GET;
    }

    /**
     * Do the validation.
     *
     * @param Document $object
     * @return mixed[]
     */
    public static function doValidate(Document $object): array
    {
        /* Get data */
        $data = (object)$object->getData();

        /* Get schema */
        $schema = (object)$object->getDocumentType()->getAllowedAttributes();

        /* do the schema validation */
        $validator = new Validator();
        $validator->validate($data, $schema);

        if ($validator->isValid()) {
            return [];
        }

        return $validator->getErrors();
    }

    /**
     * Function to validate given Document object.
     *
     * @param Document $object
     * @param ExecutionContextInterface $context
     * @return void
     */
    public static function validate(Document $object, ExecutionContextInterface $context): void
    {
        if (self::getRequestMethod() === Request::METHOD_PATCH) {
            return;
        }

        $validationErrors = self::doValidate($object);

        if (count($validationErrors) > 0) {
            foreach ($validationErrors as $error) {
                $context->buildViolation($error['message'])
                    ->atPath('data')
                    ->setCode('422')
                    ->addViolation();
            }
        }
    }
}
