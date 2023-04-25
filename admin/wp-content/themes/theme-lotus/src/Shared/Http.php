<?php

namespace Lotus\Shared;

final class Http
{
	const GET    = "GET";
	const POST   = "POST";
	const PUT    = "PUT";
	const DELETE = "DELETE";
	const PATCH  = "PATCH";
	const EDITABLE = 'POST, PUT, PATCH';

	public const NOT_FOUND   = 404;
	public const HTTP_BAD_REQUEST = 400;
}
