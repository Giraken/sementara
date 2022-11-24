<?php

namespace App\Services;

use App\Contracts\Logable;

class CustomLogger implements Logable
{
	public function __construct()
	{
		//
	}

	public function log(string $message): string
	{
		return "From log service provider: $message";
	}
}
