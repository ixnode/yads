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

namespace App\Validator\Document;

use App\Entity\Document;
use App\Exception\RequestNotExistsException;
use App\Utils\ArrayBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use JsonSchema\Validator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Class SchemaValidValidator
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-04)
 * @package App\Validator
 */
class SchemaValidValidator extends ConstraintValidator
{
    protected EntityManagerInterface $entityManager;

    protected RequestStack $requestStack;

    /**
     * SchemaValidValidator constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;

        $this->requestStack = $requestStack;
    }

    /**
     * Returns the request method
     *
     * @return string
     * @throws RequestNotExistsException
     */
    public function getRequestMethod(): string
    {
        $request = $this->requestStack->getMainRequest();

        if ($request === null) {
            throw new RequestNotExistsException('main request');
        }

        return $request->getMethod();
    }

    /**
     * Do the validation.
     *
     * @param Document $object
     * @return mixed[]
     */
    public function doValidate(Document $object): array
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
     * @param mixed $value
     * @param Constraint $constraint
     * @return void
     * @throws RequestNotExistsException
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        // Change the value name. For recognition reasons.
        $document = $value;

        // Unexpected constraint.
        if (!$constraint instanceof SchemaValid) {
            throw new UnexpectedTypeException($constraint, SchemaValid::class);
        }

        // User-defined constraints should ignore null and empty values so that other constraints (NotBlank, NotNull, etc.) can take care of them.
        if ($document === null || $document === '') {
            return;
        }

        // Check that given value is instance of graph.
        if (!$document instanceof Document) {
            throw new UnexpectedValueException($document, Document::class);
        }

        if (self::getRequestMethod() === Request::METHOD_PATCH) {
            $documentNew = clone $document;

            $documentRepository = $this->entityManager->getRepository(Document::class);
            $documentPrevious = $documentRepository->findOneBy(['id' => $document->getId()]);

            if ($documentPrevious === null) {
                $this->context->buildViolation($constraint->messageNotExists)
                    ->atPath('data')
                    ->setCode('422')
                    ->addViolation();
                return;
            }

            $this->entityManager->refresh($documentPrevious);

            $document->setData((new ArrayBuilder($documentPrevious->getData(), $documentNew->getData()))->get());
        }

        $validationErrors = $this->doValidate($document);

        if (count($validationErrors) > 0) {
            foreach ($validationErrors as $error) {
                $this->context->buildViolation($error['message'])
                    ->atPath('data')
                    ->setCode('422')
                    ->addViolation();
            }
        }
    }
}
