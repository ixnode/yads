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
     * @param int $recordNumber
     * @return array[]|int[]|string[]
     */
    public function getArray(int $recordNumber = 0): array
    {
        $data = [

            /* group document type */
            [
                'type' => 'group',
                'allowedAttributes' => [
                    '$id' => 'document.data.group.schema.json',
                    '$schema' => 'https://json-schema.org/draft/2020-12/schema',
                    'title' => 'Group document data',
                    'description' => 'Data from document of type group',
                    'type' => 'object',
                    'additionalProperties' => false,
                    'properties' => [
                        'title' => [
                            'type' => 'string',
                            'minLength' => 2,
                            'maxLength' => 255,
                            'description' => 'The title of the group.',
                        ],
                        'description' => [
                            'type' => 'string',
                            'minLength' => 10,
                            'maxLength' => 65535,
                            'description' => 'The description of the group.',
                        ]
                    ],
                    'required' => [
                        0 => 'title',
                        1 => 'description',
                    ],
                ],
                'defaults' => [
                    'title'
                ],
            ],

            /* notebook document type */
            [
                'type' => 'notebook',
                'allowedAttributes' => [
                    '$id' => 'document.data.notebook.schema.json',
                    '$schema' => 'https://json-schema.org/draft/2020-12/schema',
                    'title' => 'Notebook document data',
                    'description' => 'Data from document of type notebook',
                    'type' => 'object',
                    'additionalProperties' => false,
                    'properties' => [
                        'title' => [
                            'type' => 'string',
                            'minLength' => 2,
                            'maxLength' => 255,
                            'description' => 'The title of the notebook.',
                        ],
                        'description' => [
                            'type' => 'string',
                            'minLength' => 10,
                            'maxLength' => 65535, // 64k
                            'description' => 'The description of the notebook.',
                        ],
                        'parent' => [
                            'type' => ['integer', 'null', ],
                            'minimum' => 1,
                            'description' => 'The parent notebook id if exists.',
                        ],
                    ],
                    'required' => [
                        0 => 'title',
                        1 => 'parent',
                    ],
                ],
                'defaults' => [
                    'title'
                ],
            ],

            /* note document type */
            [
                'type' => 'note',
                'allowedAttributes' => [
                    '$id' => 'document.data.note.schema.json',
                    '$schema' => 'https://json-schema.org/draft/2020-12/schema',
                    'title' => 'Note document data',
                    'description' => 'Data from document of type note',
                    'type' => 'object',
                    'additionalProperties' => false,
                    'properties' => [
                        'title' => [
                            'type' => 'string',
                            'minLength' => 2,
                            'maxLength' => 255,
                            'description' => 'The title of the note.',
                        ],
                        'description' => [
                            'type' => 'string',
                            'minLength' => 10,
                            'maxLength' => 65535, // 64k
                            'description' => 'The description of the note.',
                        ],
                        'content' => [
                            'type' => 'string',
                            'minLength' => 10,
                            'maxLength' => 16777215, // 16M
                            'description' => 'The description of the note.',
                        ],
                    ],
                    'required' => [
                        0 => 'title',
                        1 => 'content',
                    ],
                ],
                'defaults' => [
                    'title'
                ],
            ],

            /* task document type */
            [
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
                        'completionDate' => [
                            'type' => [
                                0 => 'string',
                                1 => 'null',
                            ],
                            'format' => 'date',
                            'default' => NULL,
                            'description' => 'The date on which this task must be completed.',
                        ],
                        'completionTime' => [
                            'type' => [
                                0 => 'string',
                                1 => 'null',
                            ],
                            'format' => 'time',
                            'default' => NULL,
                            'description' => 'The time on which this task must be completed. completionDate was set and null means full day.',
                        ],
                        'completedOn' => [
                            'type' => [
                                0 => 'string',
                                1 => 'null',
                            ],
                            'format' => 'date-time',
                            'default' => NULL,
                            'description' => 'The date on which the task was done.',
                        ],
                    ],
                    'required' => [
                        0 => 'title',
                        1 => 'description',
                    ],
                ],
                'defaults' => [
                    'title'
                ],
            ],
        ];

        return array_key_exists($recordNumber, $data) ? $data[$recordNumber] : $data[0];
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
