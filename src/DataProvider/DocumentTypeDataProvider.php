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

namespace App\DataProvider;

use App\DataFixtures\DocumentTypeFixtures;
use App\Entity\BaseEntity;
use App\Entity\DocumentType;

/**
 * Class DocumentTypeDataProvider
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-07)
 * @package App\DataProvider
 */
class DocumentTypeDataProvider extends BaseDataProvider
{
    /**
     * Returns an entity as array.
     *
     * @return array[]|int[]|string[]
     */
    public function getArray(): array
    {
        return [
            'type' => 'task',
            'allowedAttributes' => [
                '$id' => 'document.data.task.schema.json',
                '$schema' => 'https://json-schema.org/draft/2020-12/schema',
                'title' => 'Task document data',
                'description' => 'Data from document of type task',
                'type' => 'object',
                'additionalProperties' => false,
                'properties' => [
                    'title' => [
                        'type' => 'string',
                        'minLength' => 2,
                        'maxLength' => 255,
                        'description' => 'The title of the task.',
                    ],
                    'description' => [
                        'type' => 'string',
                        'minLength' => 10,
                        'maxLength' => 65535,
                        'description' => 'The description of the task.',
                    ],
                    'has_date_of_completion' => [
                        'type' => 'boolean',
                    ],
                    'date_of_completion' => [
                        'type' => 'string',
                        'format' => 'date',
                        'description' => 'The date on which this task must be completed.',
                    ],
                ],
                'required' => [
                    0 => 'title',
                    1 => 'description',
                    2 => 'has_date_of_completion',
                ],
            ],
            'defaults' => [
                'title'
            ],
        ];
    }

    /**
     * Returns new DocumentType entity.
     *
     * @return BaseEntity
     */
    public function getObject(): BaseEntity
    {
        return new DocumentType();
    }
}
