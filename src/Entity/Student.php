<?php

namespace Alura\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;

#[Entity]
class Student {
	#[Id, GeneratedValue, Column]
	public int $id;

	#[OneToMany(
		mappedBy: 'student',
		targetEntity: Phone::class,
		cascade: ['persist', 'remove'],
		fetch: 'EAGER'
	)]
	private Collection $phones;

	#[ManyToMany(Course::class, inversedBy: 'students')]
	private Collection $courses;

	public function __construct(
		#[Column]
		public readonly string $name
	) {
		$this->phones = new ArrayCollection();
		$this->courses = new ArrayCollection();
	}

	public function addPhone(Phone $phone) {
		$this->phones->add($phone);
		$phone->setStudent($this);
	}

	/**
	 * @return Collection<Phone>
	 */
	public function courses(): Collection {
		return $this->courses;
	}

	/**
	 * @return Collection<Phone>
	 */
	public function phones(): Collection {
		return $this->phones;
	}

	public function enrollInCourse(Course $course): void {
		if ($this->courses->contains($course)) {
			return;
		}

		$this->courses->add($course);
		$course->addStudent($this);
	}
}
