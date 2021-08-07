<?php

namespace App\DataProvider;

use App\DataFixtures\DocumentTypeFixtures;
use App\Entity\BaseEntity;
use App\Entity\Role;

/**
 * Class RoleDataProvider
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-01)
 * @package App\DataProvider
 */
class RoleDataProvider extends BaseDataProvider
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
            'name' => 'Role example name',
            'description' => 'Role example name',
        ];
    }

    /**
     * Returns new Role entity.
     *
     * @return BaseEntity
     */
    public function getObject(): BaseEntity
    {
        return new Role();
    }
}
