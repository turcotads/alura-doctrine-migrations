<?php

namespace Alura\Doctrine\Helper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class EntityManagerCreator {
	public static function createEntityManager(): EntityManager {
		$isDevMode = true;
		$config = ORMSetup::createAttributeMetadataConfiguration(
			[__DIR__ . '/..'],
			$isDevMode
		);

		$conn = [
			'driver' => 'pdo_sqlite',
			'path' => __DIR__ . '/../../db.sqlite',
		];

		return EntityManager::create($conn, $config);
	}
}
