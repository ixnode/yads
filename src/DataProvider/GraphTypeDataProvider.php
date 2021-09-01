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
use App\Entity\GraphType;

/**
 * Class GraphTypeDataProvider
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-16)
 * @package App\DataProvider
 */
class GraphTypeDataProvider extends BaseDataProvider
{
    const DIRECTION_TYPE_BIDIRECTIONAL = 'bidirectional';

    const DIRECTION_TYPE_UNIDIRECTIONAL = 'unidirectional';

    const DIRECTION_TYPE_NOT_DIRECTED = 'not_directed';

    /**
     * Returns an entity as array.
     *
     * @param int $recordNumber
     * @return array[]|int[]|string[]
     */
    public function getArray(int $recordNumber = 0): array
    {
        $data = [

            // graph_type bidirectional
            [
                'title' => 'Bidirectional 1',
                'titleReverse' =>  'Bidirectional Reverse 1',
                'graphType' => self::DIRECTION_TYPE_BIDIRECTIONAL,
            ],

            // graph_type unidirectional
            [
                'title' => 'Unidirectional 2',
                'titleReverse' =>  'Unidirectional Reverse 2',
                'graphType' => self::DIRECTION_TYPE_UNIDIRECTIONAL,
            ],

            // graph_type not directed
            [
                'title' => 'Not directed 3',
                'titleReverse' =>  'Not directed Reverse 3',
                'graphType' => self::DIRECTION_TYPE_NOT_DIRECTED,
            ],
        ];

        return array_key_exists($recordNumber, $data) ? $data[$recordNumber] : $data[0];
    }

    /**
     * Returns new GraphType entity.
     *
     * @return BaseEntity
     */
    public function getObject(): BaseEntity
    {
        return new GraphType();
    }
}
