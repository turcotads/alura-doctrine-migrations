<?php

use Alura\Doctrine\Entity\Phone;
use Alura\Doctrine\Entity\Student;
use Alura\Doctrine\Helper\EntityManagerCreator;

require __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

$student = new Student('Aluno com Telefone');
$student->addPhone(new Phone('(53) 9999-999999'));
$student->addPhone(new Phone('(53) 2222-222222'));
$entityManager->persist($student);
$entityManager->flush();
