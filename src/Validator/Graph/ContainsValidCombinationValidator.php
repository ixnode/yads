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

namespace App\Validator\Graph;

use App\Entity\Graph;
use App\Service\GraphRuleService;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Class ContainsValidCombinationValidator
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-09-01)
 * @package App\Validator
 */
class ContainsValidCombinationValidator extends ConstraintValidator
{
    private GraphRuleService $graphRuleService;

    /**
     * ContainsValidCombinationValidator constructor.
     *
     * @param GraphRuleService $graphRuleService
     */
    public function __construct(GraphRuleService $graphRuleService)
    {
        $this->graphRuleService = $graphRuleService;
    }

    /**
     * The validation method.
     *
     * @param mixed $value
     * @param Constraint $constraint
     * @throws UnexpectedTypeException
     * @throws UnexpectedValueException
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        // Change the value name. For recognition reasons.
        $graph = $value;

        // Unexpected constraint.
        if (!$constraint instanceof ContainsValidCombination) {
            throw new UnexpectedTypeException($constraint, ContainsValidCombination::class);
        }

        // User-defined constraints should ignore null and empty values so that other constraints (NotBlank, NotNull, etc.) can take care of them.
        if ($graph === null || $graph === '') {
            return;
        }

        // Check that given value is instance of graph.
        if (!$graph instanceof Graph) {
            throw new UnexpectedValueException($graph, Graph::class);
        }

        // Get needed graph properties
        $graphType = $graph->getGraphType();
        $sourceDocumentType = $graph->getDocumentSource()->getDocumentType();
        $targetDocumentType = $graph->getDocumentTarget()->getDocumentType();

        // Skip validation for reversed entity.
        if ($graph->getGraphTypeReversed()) {
            return;
        }

        // Try to find a graph rule for this constellation.
        $graphRule = $this->graphRuleService->getOneBySourceDocumentTypeTargetDocumentTypeAndGraphType($sourceDocumentType, $targetDocumentType, $graphType);

        // No graph rule was found. This means that this rule is not configured and therefore not allowed.
        if ($graphRule === null) {
            $this->context->buildViolation($constraint->messageCombinationNotAllowed)->setParameters([
                '{{sourceDocumentType}}' => $sourceDocumentType->getType(),
                '{{targetDocumentType}}' => $targetDocumentType->getType(),
                '{{graphType}}' => $graphType->getGraphType(),
            ])->addViolation();
            return;
        }

        // Given role is only allowed, if role id was set.
        if ($graph->getRole() && $graphRule->getRole() === null) {
            $this->context->buildViolation($constraint->messageRoleNotAllowed)->addViolation();
        }
    }
}
