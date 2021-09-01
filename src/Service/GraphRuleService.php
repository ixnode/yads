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

namespace App\Service;

use App\Entity\DocumentType;
use App\Entity\GraphRule;
use App\Entity\GraphType;
use App\Repository\GraphRuleRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class GraphRuleService
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-09-01)
 * @package App\Service
 */
class GraphRuleService
{
    private EntityManagerInterface $manager;

    private GraphRuleRepository $graphRuleRepository;

    /**
     * GraphService constructor.
     *
     * @param EntityManagerInterface $manager
     * @param GraphRuleRepository $graphRuleRepository
     */
    public function __construct(EntityManagerInterface $manager, GraphRuleRepository $graphRuleRepository)
    {
        $this->manager = $manager;

        $this->graphRuleRepository = $graphRuleRepository;
    }

    /**
     * Returns one Graph entity by defined criteria.
     *
     * @param DocumentType $source
     * @param DocumentType $target
     * @param GraphType $graphType
     * @return GraphRule|null
     */
    public function getOneBySourceDocumentTypeTargetDocumentTypeAndGraphType(DocumentType $source, DocumentType $target, GraphType $graphType): ?GraphRule
    {
        return $this->graphRuleRepository->findOneBy([
            'documentTypeSource' => $source,
            'documentTypeTarget' => $target,
            'graphType' => $graphType,
        ]);
    }
}
