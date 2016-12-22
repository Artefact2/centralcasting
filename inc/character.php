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

	const CHILD = 0;
	const ADOLESCENT = 1;
	const ADULT = 2;

	private $name;
	private $type;
	private $ageRange;

	private $modifiers = [
		'CuMod' => 0, /* Cultural modifier */
		'SolMod' => 0, /* Social status modifier */
		'LegitMod' => 0, /* Birth legitimacy modifier */
		'BiMod' => 0, /* Birth modifier */
		'TiMod' => 0, /* Title modifier */
	];
	
	public $CuMod = 0;
	public $SolMod = 0;
	public $LegitMod = 0;
	public $BiMod = 0;
	public $TiMod = 0;

	public $traits = [
		'L' => 0,
		'D' => 0,
		'N' => 0,
		'R' => 0,
	];
	
	private $rootEntry;
	private $activeEntry;

	public function __construct($name = 'Unnamed character', $type = self::PC, $ageRange = self::CHILD) {
		$this->setName($name);
		$this->setType($type);
		$this->setAgeRange($ageRange);

		$this->rootEntry = new Entry("000", "Root entry");
		$this->activeEntry = $this->rootEntry;
	}

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): void {
		$this->name = $name;
	}

	public function getType(): int {
		return $this->type;
	}

	public function setType(int $type): void {
		$this->type = $type;
	}

	public function getAgeRange(): int {
		return $this->ageRange;
	}

	public function setAgeRange(int $ageRange): void {
		$this->ageRange = $ageRange;
	}

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
