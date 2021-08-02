<?php

namespace App\DataProvider;

use App\DataFixtures\DocumentTypeFixtures;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use ReflectionException;
use ReflectionObject;

/**
 * Class RoleDataProvider
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-01)
 * @package App\DataProvider
 */
class RoleDataProvider
{
    const NAME_ID = 'id';

    /**
     * @param object $object
     * @param int $id
     * @return object
     * @throws ReflectionException
     * @throws Exception
     */
    private function setId(object $object, int $id): object
    {
        $reflector = new ReflectionObject($object);

        if (!$reflector->hasProperty(self::NAME_ID)) {
            throw new Exception(sprintf('The given object "%s" must have the property "%s".', get_class($object), self::NAME_ID));
        }

        $property = $reflector->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($object, $id);

        return $object;
    }

    /**
     * Returns an entity as array.
     *
     * @return array{id: int, name: string, description: string}
     */
    public function getEntityArray(): array
    {
        return [
            'id' => 1,
            'name' => 'Role example name',
            'description' => 'Role example name',
        ];
    }

    /**
     * Returns an entity as json.
     *
     * @return string
     */
    public function getEntityJson(): string
    {
        $json = json_encode($this->getEntityArray());

        if ($json === false) {
            return '{}';
        }

        return $json;
    }

    /**
     * Returns a role entity.
     *
     * @see: https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/working-with-objects.html
     *
     * @return Role
     * @throws ReflectionException
     */
    public function getEntityObject(): Role
    {
        $array = $this->getEntityArray();

        /** @var Role $role */
        $role = $this->setId(new Role(), $array['id']);
        $role->setName('Role example name');
        $role->setDescription('Role example name');

        return $role;
    }
}
