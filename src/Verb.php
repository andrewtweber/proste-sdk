<?php

namespace Proste;

/**
 * Enum Verb
 *
 * @package Proste
 */
enum Verb: string
{
    case Get = 'GET';
    case Post = 'POST';
    case Put = 'PUT';
    case Patch = 'PATCH';
    case Delete = 'DELETE';
}
