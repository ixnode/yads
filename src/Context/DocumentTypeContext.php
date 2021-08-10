<?php

namespace App\Context;

use App\Entity\DocumentType;

/**
 * Class DocumentTypeContext
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-10)
 * @package App\Context
 */
final class DocumentTypeContext extends BaseContext
{
    /**
     * Returns the DocumentType entity class.
     *
     * @return string
     */
    public function getClass(): string
    {
        return DocumentType::class;
    }

    /**
     * Returns the type of this class.
     *
     * @return string
     */
    public function getType(): string
    {
        return 'DocumentType';
    }

    /**
     * Returns the single path name.
     *
     * @return string
     */
    public function getPathName(): string
    {
        return 'document_types';
    }
}
