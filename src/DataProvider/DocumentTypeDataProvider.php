<?php

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
            'id' => 1,
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
