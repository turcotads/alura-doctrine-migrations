<?php

use Alura\Doctrine\Entity\Course;
use Alura\Doctrine\Entity\Phone;
use Alura\Doctrine\Entity\Student;
use Alura\Doctrine\Helper\EntityManagerCreator;

require __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();
$dql = 'SELECT student, phone, course
		FROM Alura\\Doctrine\\Entity\\Student student
		LEFT JOIN student.phones phone
		LEFT JOIN student.courses course';

/** @var Student[] $studentList */
$studentList = $entityManager->createQuery($dql)->getResult();
foreach ($studentList as $student) {
	echo "ID: $student->id\nNome: $student->name";

	$phones = $student->phones();
	$courses = $student->courses();

	if ($phones->count()) {
		echo PHP_EOL;
		echo 'Telefone(s): ';

		echo implode(', ', ($phones
			->map(fn (Phone $phone) => $phone->number)
			->toArray()));
	}

	if ($courses->count()) {
		echo PHP_EOL;
		echo 'Curso(s): ';

		echo implode(', ', ($courses
			->map(fn (Course $course) => $course->name)
			->toArray()));
	}
	echo PHP_EOL . PHP_EOL;
}

echo 'Count: ' . count($studentList) . PHP_EOL . PHP_EOL;
