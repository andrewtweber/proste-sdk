<?php

namespace Proste\Exceptions;

use Proste\SDK;
use RuntimeException;
use Throwable;

/**
 * Class HttpException
 *
 * @package Proste\Exceptions
 */
class HttpException extends RuntimeException
{
    /**
     * @param SDK            $sdk
     * @param int            $code
     * @param Throwable|null $previous
     *
     * @return HttpException
     */
    public static function make(SDK $sdk, int $code, ?Throwable $previous = null): HttpException
    {
        $message = $sdk->name . ' API failed';

        return match ($code) {
            401 => new Http401UnauthorizedException($message, $code, $previous),
            403 => new Http403ForbiddenException($message, $code, $previous),
            404 => new Http404NotFoundException($message, $code, $previous),
            default => new static($message, $code, $previous),
        };
    }
}
