<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Document;
use App\Exception\IndexNotExistsException;
use App\Exception\ValidationException;
use App\Repository\DocumentRepository;
use App\Validator\DocumentValidator;
use ContainerCxLcGjZ\getTranslation_ProviderFactory_NullService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

final class DocumentItemDataPersister implements ContextAwareDataPersisterInterface
{
    const NAME_ITEM_OPERATION_NAME = 'item_operation_name';

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
     * @throws IndexNotExistsException
     * @throws ValidationException
     */
    public function persist($data, array $context = []): mixed
    {
        // Check context values
        if (!array_key_exists(self::NAME_ITEM_OPERATION_NAME, $context)) {
            $context[self::NAME_ITEM_OPERATION_NAME] = Request::METHOD_GET;
        }
        $itemOperationName = strtoupper($context[self::NAME_ITEM_OPERATION_NAME]);

        // Merge data if patch method is requested
        if ($itemOperationName === Request::METHOD_PATCH) {
            if (!array_key_exists(self::NAME_PREVIOUS_DATA, $context)) {
                throw new IndexNotExistsException(self::NAME_PREVIOUS_DATA);
            }

            /** @var Document $previousData */
            $previousData = $context[self::NAME_PREVIOUS_DATA];

            $data->setData(array_merge($previousData->getData(), $data->getData()));

            $validationErrors = DocumentValidator::doValidate($data);

            if (count($validationErrors) > 0) {
                foreach ($validationErrors as $error) {
                    throw new ValidationException($error['message']);
                }
            }
        }

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
