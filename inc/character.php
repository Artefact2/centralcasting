<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;

class Character {
	const PC = 0;
	const NPC = 1;

	const CHILD = 10;
	const ADOLESCENT = 11;
	const ADULT = 12;

	const MALE = 20;
	const FEMALE = 21;

	private $name;
	private $type;
	private $ageRange;
	private $alive; /* bool */
	private $gender;

	private $modifiers = [
		'CuMod' => 0, /* Cultural modifier */
		'SolMod' => 0, /* Social status modifier */
		'LegitMod' => 0, /* Birth legitimacy modifier */
		'BiMod' => 0, /* Birth modifier */
		'TiMod' => 0, /* Title modifier */
	];

	private $mother; /* ?Character */
	private $father; /* ?Character */
	private $guardian; /* ?Character */
	private $grandparents; /* ?Character[] */
	private $cousins; /* int */
	private $siblings; /* int */
	private $illegitSiblings; /* int */

	/* XXX */
	public $traits = [
		'L' => 0,
		'D' => 0,
		'N' => 0,
		'R' => 0,
	];
	
	private $rootEntry;
	private $activeEntry;

	public function __construct(string $name, int $type, int $ageRange) {
		$this->setName($name);
		$this->setType($type);
		$this->setAgeRange($ageRange);

		$this->mother = null;
		$this->father = null;
		$this->guardian = null;
		$this->grandparents = [ null, null, null, null ]; /* MGM, MGF, PGM, PGF */
		$this->cousins = 0;
		$this->siblings = 0;
		$this->illegitSiblings = 0;

		$this->alive = true;
		$this->gender = null;

		$this->rootEntry = new Entry("000", "Root entry");
		$this->activeEntry = $this->rootEntry;
	}

	public static function PC(): Character {
		return new self('Player Character', self::PC, self::CHILD);
	}

	public static function NPC(string $name): Character {
		return new self($name, self::NPC, self::ADULT);
	}

	public function getName(): string { return $this->name;	}
	public function setName(string $name): void { $this->name = $name; }

	public function getType(): int { return $this->type; }
	public function setType(int $type): void {
		assert(in_array($type, [ self::PC, self::NPC ], true));
		$this->type = $type;
	}

	public function getAgeRange(): int { return $this->ageRange; }
	public function setAgeRange(int $ageRange): void {
		assert(in_array($ageRange, [ self::CHILD, self::ADOLESCENT, self::ADULT ], true));
		$this->ageRange = $ageRange;
	}

	public function getMother(): ?Character { return $this->mother; }
	public function setMother(?Character $m): void { $this->mother = $m; }

	public function getFater(): ?Character { return $this->father; }
	public function setFather(?Character $f): void { $this->father = $f; }

	public function getGuardian(): ?Character { return $this->guardian; }
	public function setGuardian(?Character $g): void { $this->guardian = $g; }

	public function getGrandparents(): array { return $this->grandparents; }
	public function setGrandparent(int $pos, ?Character $gp): void {
		assert($pos >= 0 && $pos <= 3);
		$this->grandparents[$pos] = $gp;
	}

	public function getNumCousins(): int { return $this->cousins; }
	public function setNumCousins(int $n): void {
		assert($n >= 0);
		$this->cousins = $n;
	}

	public function getGender(): int { return $this->gender; }
	public function setGender(int $g): void {
		assert(in_array($g, [ self::MALE, self::FEMALE ], true));
		$this->gender = $g;
	}

	public function isAlive(): bool { return $this->alive; }
	public function kill(): void { $this->alive = false; }

	public function getModifier(string $mod): int {
		assert(isset($this->modifiers[$mod]));
		return $this->modifiers[$mod];
	}

	public function setModifier(string $mod, int $v): void {
		assert(isset($this->modifiers[$mod]));
		$this->modifiers[$mod] = $v;
	}

	public function increaseModifier(string $mod, int $v): void {
		assert(isset($this->modifiers[$mod]));
		$this->modifiers[$mod] += $v;
	}

	public function getRootEntry(): Entry {
		return $this->rootEntry;
	}

	public function getActiveEntry(): Entry {
		return $this->activeEntry;
	}

	public function setActiveEntry(Entry $e): void {
		$e2 = $e;		
		while($e2 !== $this->rootEntry) {
			$e2 = $e2->getParent();
			assert($e2 !== null);
		}
		
		$this->activeEntry = $e;
	}

	public function printPlaintextSummary(): void {
		static $prefix = '|   ';
		static $cprefix = '+ ';
		static $ncprefix = '| ';
		static $len = 120;

		$modline = [];
		foreach($this->modifiers as $k => $v) {
			$modline[] = sprintf("%s: %+2d", $k, $v);
		}
		$modline = implode(", ", $modline);

		$hlen = $len - strlen($modline) - 3;
		printf("%-".$hlen.".".$hlen."s (%s)\n", $this->getName(), $modline);
		echo str_repeat("=", $len), "\n";

		$traverse = function(Entry $e, int $level) use($len, $prefix, $cprefix, $ncprefix, &$traverse) {
			$prefix = str_repeat($prefix, $level);

			$lines = $e->getLines();
			if($lines === []) $lines[] = '';

			$haschildren = $e->getChildren() !== [];
			
			$first = true;
			foreach($lines as $line) {
				if($first) {
					$first = false;
					$hlen = $len - 7;
					printf(
						"%-".$hlen.".".$hlen."s(%-5.5s)\n",
						$prefix
						.($haschildren ? $cprefix : '')
						.$e->getSourceName().': '
						.$line, $e->getSourceID()
					);
				} else {
					printf(
						"%-".$len.".".$len."s\n",
						$prefix
						.($haschildren ? $ncprefix : '')
						.$line
					);
				}
			}

			foreach($e->getChildren() as $c) {
				$traverse($c, $level + 1);
			}
		};

		foreach($this->getRootEntry()->getChildren() as $e) {
			$traverse($e, 0);
		}
	}
}
