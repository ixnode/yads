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

namespace App\Utils;

/**
 * Class ExceptionHolder
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 1.0 (2021-08-30)
 * @package App\Utils
 */
class ExceptionHolder
{
    /** @var class-string<\Throwable> $class */
    protected string $class;

    protected int $code;

    protected string $message;

    /**
     * ExceptionHolder constructor.
     *
     * @param class-string<\Throwable> $class
     * @param int $code
     * @param string $message
     */
    public function __construct(string $class, int $code, string $message)
    {
        $this->class = $class;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Returns the class of this ExceptionHolder.
     *
     * @return class-string<\Throwable>
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * Sets the class of this ExceptionHolder.
     *
     * @param class-string<\Throwable> $class
     * @return ExceptionHolder
     */
    public function setClass(string $class): ExceptionHolder
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Returns the code of this ExceptionHolder.
     *
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Sets the code of this ExceptionHolder.
     *
     * @param int $code
     * @return ExceptionHolder
     */
    public function setCode(int $code): ExceptionHolder
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Returns the message of this ExceptionHolder.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Sets the message of this ExceptionHolder.
     *
     * @param string $message
     * @return ExceptionHolder
     */
    public function setMessage(string $message): ExceptionHolder
    {
        $this->message = $message;
        return $this;
    }
}
