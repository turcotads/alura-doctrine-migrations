<?php

use Alura\Doctrine\Entity\Course;
use Alura\Doctrine\Helper\EntityManagerCreator;

require __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

$course = new Course('Doctrine');
$course2 = new Course('PHP');
$course3 = new Course('Symfony');
$entityManager->persist($course);
$entityManager->persist($course2);
$entityManager->persist($course3);
$entityManager->flush();
