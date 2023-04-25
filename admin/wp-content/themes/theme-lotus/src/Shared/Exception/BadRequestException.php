<?php

namespace Lotus\Shared\Exception;

use Exception;

class BadRequestException extends Exception 
{
	protected $message = 'Bad Request, parameter or entity is missing';

	protected $code = 400;
}