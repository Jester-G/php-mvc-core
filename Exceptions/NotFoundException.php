<?php

namespace jesterone\mvccore\Exceptions;

class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;

}