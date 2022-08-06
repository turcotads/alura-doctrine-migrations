<?php

use Alura\Doctrine\Entity\Course;
use Alura\Doctrine\Entity\Phone;
use Alura\Doctrine\Entity\Student;
use Alura\Doctrine\Helper\EntityManagerCreator;

require __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();
$studentRepository = $entityManager->getRepository(Student::class);

/** @var Student[] $studentList */
$studentList = $studentRepository->findAll();
foreach ($studentList as $student) {
	echo "ID: $student->id\nNome: $student->name";

	$phones = $student->phones();
	$courses = $student->courses();

	if ($phones->count()) {
		echo PHP_EOL;
		echo "Telefone(s): ";

		echo implode(', ', ($phones
			->map(fn (Phone $phone) => $phone->number)
			->toArray()));
	}

	if ($courses->count()) {
		echo PHP_EOL;
		echo "Curso(s): ";

		echo implode(', ', ($courses
			->map(fn (Course $course) => $course->name)
			->toArray()));
	}
	echo PHP_EOL . PHP_EOL;
}

echo 'Count: ' . $studentRepository->count([]) . PHP_EOL . PHP_EOL;

/* @var Student $student */
$student = $studentRepository->find(2);
echo "ID: $student->id Nome: $student->name\n\n";

/* @var Student $student */
$student = $studentRepository->findOneBy([
	'name' => 'Fabio Madeira Peres',
]);
echo "ID: $student->id Nome: $student->name\n\n";
