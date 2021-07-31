<?php

namespace App\Utils;

/**
 * Class NamingConventionsConverter
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-07-31)
 * @package App\Utils
 */
class NamingConventionsConverter
{
    /** @var string|string[] */
    protected string|array $raw;

    /** @var string[] */
    protected array $words;

    /**
     * NamingConventionsConverter constructor.
     *
     * @param string|string[] $raw
     */
    public function __construct(string|array $raw)
    {
        $this->raw = $raw;

        $this->words = $this->convertRawToWords($raw);
    }

    /**
     * Converts given raw input into words.
     *
     * @param string|string[] $raw
     * @return string[]
     */
    protected function convertRawToWords(string|array $raw): array
    {
        /* Convert array to string */
        if (is_array($raw)) {
            $raw = implode('_', $raw);
        }

        /* Convert capitalized letters */
        $replaced = preg_replace('~([A-Z]+)~', ' $1', $raw);

        /* Check conversion */
        if ($replaced !== null) {
            $raw = $replaced;
        }

        /* Convert all _ or [SPACE] to [SPACE] */
        $replaced = preg_replace('~[ _]+~', ' ', trim($raw));

        /* Check conversion */
        if ($replaced !== null) {
            $raw = $replaced;
        }

        /* Build single point of truth */
        return explode(' ', strtolower($raw));
    }

    /**
     * Gets given raw format.
     *
     * @return string|string[]
     */
    public function getRaw(): string|array
    {
        return $this->raw;
    }

    /**
     * Gets converted words (single point of truth).
     *
     * @return string[]
     */
    public function getWords(): array
    {
        return $this->words;
    }

    /**
     * Gets title of internal $this->words array.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return ucwords(implode(' ', $this->words));
    }

    /**
     * Gets PascalCase representation of internal $this->words array.
     *
     * @return string
     */
    public function getPascalCase(): string
    {
        return implode('', array_map(function ($word) { return ucfirst($word); }, $this->words));
    }

    /**
     * Gets camelCase representation of internal $this->words array.
     *
     * @return string
     */
    public function getCamelCase(): string
    {
        return lcfirst($this->getPascalCase());
    }

    /**
     * Gets under_scored representation of internal $this->words array.
     *
     * @return string
     */
    public function getUnderscored(): string
    {
        return implode('_', $this->words);
    }

    /**
     * Gets CONSTANT representation of internal $this->words array.
     *
     * @return string
     */
    public function getConstant(): string
    {
        return strtoupper($this->getUnderscored());
    }
}
