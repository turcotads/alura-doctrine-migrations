<?php

use Alura\Doctrine\Entity\Course;
use Alura\Doctrine\Entity\Phone;
use Alura\Doctrine\Entity\Student;
use Alura\Doctrine\Helper\EntityManagerCreator;

require __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();
$studentRepository = $entityManager->getRepository(Student::class);
$studentList = $studentRepository->studentsAndCourses();
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

$dql = 'SELECT count(student) FROM Alura\\Doctrine\\Entity\\Student student WHERE student.phones IS EMPTY';
$query = $entityManager->createQuery($dql)->enableResultCache(84600);

echo 'Count: ' . $query->getSingleScalarResult() . PHP_EOL . PHP_EOL;
