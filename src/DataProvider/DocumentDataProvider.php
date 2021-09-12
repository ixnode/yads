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
use App\Entity\Document;

/**
 * Class DocumentDataProvider
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-12)
 * @package App\DataProvider
 */
class DocumentDataProvider extends BaseDataProvider
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

            /* group document */
            [
                'documentType' => '/api/v1/document_types/1',
                'data' => [
                    'title' => 'test 1',
                    'description' => 'test 1',
                ],
            ],

            /* notebook document */
            [
                'documentType' => '/api/v1/document_types/2',
                'data' => [
                    'title' => 'test 2',
                    'parent' => null,
                ],
            ],

            /* note document */
            [
                'documentType' => '/api/v1/document_types/3',
                'data' => [
                    'title' => 'test 3',
                    'content' => 'test 3',
                ],
            ],

            /* task document */
            [
                'documentType' => '/api/v1/document_types/4',
                'data' => [
                    'title' => 'Submit income tax return',
                    'description' => 'The income tax return must be completed.',
                    'completionDate' => '2021-09-30',
                    'completionTime' => '10:00:00',
                ],
            ],
//            [
//                'documentType' => '/api/v1/document_types/4',
//                'data' => [
//                    'title' => 'Submit income tax return',
//                    'description' => 'The income tax return must be completed.',
//                    'completionDate' => '2021-09-30',
//                    'completionTime' => '10:00:00',
//                    'completedOn' => '2021-09-06T23:05:00',
//                ],
//            ],
        ];

        return array_key_exists($recordNumber, $data) ? $data[$recordNumber] : $data[0];
    }

    /**
     * Returns new Document entity.
     *
     * @return BaseEntity
     */
    public function getObject(): BaseEntity
    {
        return new Document();
    }
}
