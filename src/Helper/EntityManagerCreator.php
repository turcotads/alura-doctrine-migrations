<?php

namespace Alura\Doctrine\Helper;

use Doctrine\DBAL\Logging\Middleware;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

class EntityManagerCreator {
	public static function createEntityManager(): EntityManager {
		$isDevMode = true;
		$config = ORMSetup::createAttributeMetadataConfiguration(
			[__DIR__ . '/..'],
			$isDevMode
		);

		$consoleOutput = new ConsoleOutput(ConsoleOutput::VERBOSITY_DEBUG);
		$consoleLogger = new ConsoleLogger($consoleOutput);
		$logMiddleware = new Middleware($consoleLogger);
		$config->setMiddlewares([
			$logMiddleware,
		]);

		$cacheDirectory = __DIR__ . '/../../var/cache';

		$config->setMetadataCache(new PhpFilesAdapter(
			namespace: 'metadata_cache',
			directory: $cacheDirectory
		));

		$config->setQueryCache(new PhpFilesAdapter(
			namespace: 'query_cache',
			directory: $cacheDirectory
		));

		$config->setResultCache(new PhpFilesAdapter(
			namespace: 'result_cache',
			directory: $cacheDirectory
		));

		$conn = [
			'driver' => 'pdo_pgsql',
			'user' => 'docker',
			'password' => 'docker',
			'host' => 'localhost',
			'port' => '5432',
			'dbname' => 'docker',
		];

		return EntityManager::create($conn, $config);
	}
}
