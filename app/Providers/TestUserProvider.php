<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\UserProvider;

class TestUserProvider extends EloquentUserProvider implements UserProvider
{
    private const password = '$2y$10$zvbsYg6H1Zn9.kLu6rdfIuOmjU0hjMhNhkTnrHk5OrpIkb9qZk7Hy';

	/**
	 * @inheritDoc
	 */
	public function validateCredentials($user, array $credentials)
	{
        $plain = $credentials['password'];

		return $this->hasher->check($plain, self::password);
	}
}
