<?php

namespace Alura\Doctrine\Repository;

use Alura\Doctrine\Entity\Student;
use Doctrine\ORM\EntityRepository;

class DoctrineStudentRepository extends EntityRepository {
	/**
	 * @return Student[]
	 */
	public function studentsAndCourses(): array {
		$dql = 'SELECT student, phone, course
		FROM Alura\\Doctrine\\Entity\\Student student
		LEFT JOIN student.phones phone
		LEFT JOIN student.courses course';

		return $this->getEntityManager()
			->createQuery($dql)
			->getResult();
	}
}
