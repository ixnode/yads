<?php

namespace App\Context;

use App\Entity\Role;

/**
 * Class RoleContext
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-10)
 * @package App\Context
 */
final class RoleContext extends BaseContext
{
    /**
     * Returns the DocumentType entity class.
     *
     * @return string
     */
    public function getClass(): string
    {
        return Role::class;
    }

    /**
     * Returns the type of this class.
     *
     * @return string
     */
    public function getType(): string
    {
        return 'Role';
    }

    /**
     * Returns the single path name.
     *
     * @return string
     */
    public function getPathName(): string
    {
        return 'roles';
    }
}
