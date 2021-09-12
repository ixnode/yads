<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Document;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

final class DocumentItemDataPersister implements ContextAwareDataPersisterInterface
{
    const NAME_PREVIOUS_DATA = 'previous_data';

    private EntityManagerInterface $manager;

    private DocumentRepository $documentRepository;

    /**
     * DocumentItemDataProvider constructor.
     *
     * @param EntityManagerInterface $manager
     * @throws Exception
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

        $documentRepository = $manager->getRepository(Document::class);

        /* Check repository class. */
        if (!$documentRepository instanceof DocumentRepository) {
            throw new Exception(sprintf(
                'Expect class "%s" but got class "%s (%s:%d)"',
                'DocumentRepository',
                get_class($documentRepository),
                __FILE__,
                __LINE__
            ));
        }

        $this->documentRepository = $documentRepository;
    }

    /**
     * @param mixed $data
     * @param string[] $context
     * @return bool
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Document;
    }

    /**
     * Persists the given $data.
     *
     * @param Document $data
     * @param string[] $context
     * @return mixed
     */
    public function persist($data, array $context = []): mixed
    {
        $this->manager->persist($data);
        $this->manager->flush();

        return $data;
    }

    /**
     * @param mixed $data
     * @param string[] $context
     */
    public function remove($data, array $context = []): void
    {
        $this->manager->remove($data);
        $this->manager->flush();
    }
}
