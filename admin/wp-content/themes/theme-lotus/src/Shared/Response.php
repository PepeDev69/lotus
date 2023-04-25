<?php

namespace Lotus\Shared;

final class Response extends \WP_REST_Response
{

	public const HTTP_BAD_REQUEST = 400;
	public const HTTP_NOT_FOUND   = 404;

	public function __construct($data, int $error_code = 200)
	{
		parent::__construct($data, $error_code);
	}
}
