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

	/* XXX find a better place to put this */
	const MILITARY_RANKS = [ /* index => [ rank, roll on 538 ] */
		1 =>  [     1,  10 ],
		2 =>  [     2,  12 ],
		3 =>  [     3,  15 ],
		4 =>  [     5,  16 ],
		5 =>  [     8,  18 ],
		6 =>  [    15,  20 ],
		7 =>  [    25,  24 ],
		8 =>  [   100,  25 ],
		9 =>  [   500, 101 ],
		10 => [  1000, 102 ],
		11 => [  3000, 103 ],
		12 => [  6000, 104 ],
		13 => [ 10000, 105 ],
	];

	private $name;
	private $type;
	private $ageRange;
	private $alive; /* bool */
	private $gender;
	private $enslaved; /* bool */
	private $imprisoned; /* bool */
	private $inmilitary; /* bool */
	private $militaryrank;

	private $modifiers = [
		'CuMod' => 0, /* Cultural modifier */
		'SolMod' => 0, /* Social status modifier */
		'LegitMod' => 0, /* Birth legitimacy modifier */
		'BiMod' => 0, /* Birth modifier */
		'TiMod' => 0, /* Title modifier */
		'ViMod' => 0, /* Military victories modifier */
	];

	private $mother; /* ?Character */
	private $father; /* ?Character */
	private $guardian; /* ?Character */
	private $grandparents; /* ?Character[] */
	private $cousins; /* int */
	private $brothers; /* int */
	private $sisters; /* int */
	private $illegitSiblings; /* int */
	private $spouse; /* ?Character */
	private $patron; /* ?Character */

	private $traits = [
		'L' => 0, /* Lightside */
		'D' => 0, /* Darkside */
		'N' => 0, /* Neutral */
		'R' => 0, /* Random */
	];
	
	private $rootEntry;
	private $activeEntry;

	private $tableInfo; /* id -> range -> bool */

	public function __construct(string $name, int $type, int $ageRange) {
		$this->setName($name);
		$this->setType($type);
		$this->setAgeRange($ageRange);

		$this->mother = null;
		$this->father = null;
		$this->guardian = null;
		$this->grandparents = [ null, null, null, null ]; /* MGM, MGF, PGM, PGF */
		$this->cousins = 0;
		$this->brothers = 0;
		$this->sisters = 0;
		$this->illegitSiblings = 0;
		$this->spouse = null;
		$this->patron = null;

		$this->alive = true;
		$this->gender = null;
		$this->enslaved = false;
		$this->imprisoned = false;
		$this->inmilitary = false;
		$this->militaryrank = 0;

		$this->rootEntry = new Entry("000", "Root entry");
		$this->activeEntry = $this->rootEntry;

		$this->tableInfo = [];
	}

	public static function PC(): Character {
		return new self('Player Character', self::PC, self::CHILD);
	}

	public static function NPC(string $name): Character {
		$c = new self($name, self::NPC, self::ADULT);
		$c->setMother(new self("Mother of ".$name, self::NPC, self::ADULT));
		$c->setFather(new self("Father of ".$name, self::NPC, self::ADULT));
		$c->setSpouse(new self("Lover of ".$name, self::NPC, self::ADULT));
		for($i = 0; $i < 4; ++$i) $c->setGrandparent($i, new self("Grandparent #".$i." of ".$name, self::NPC, self::ADULT));
		$c->setNumCousins(10);
		$c->setNumBrothers(2);
		$c->setNumSisters(2);
		return $c;
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

	public function hasMother(): bool { return $this->mother !== null && $this->mother->alive; }
	public function getMother(): ?Character { return $this->mother; }
	public function setMother(?Character $m): void { $this->mother = $m; }

	public function hasFather(): bool { return $this->father !== null && $this->father->alive; }
	public function getFather(): ?Character { return $this->father; }
	public function setFather(?Character $f): void { $this->father = $f; }

	public function hasGuardian(): bool { return $this->guardian !== null && $this->guardian->alive; }
	public function getGuardian(): ?Character { return $this->guardian; }
	public function setGuardian(?Character $g): void { $this->guardian = $g; }

	public function hasSpouse(): bool { return $this->spouse !== null && $this->spouse->alive; }
	public function getSpouse(): ?Character { return $this->spouse; }
	public function setSpouse(?Character $s): void { $this->spouse = $s; }

	public function hasPatron(): bool { return $this->patron !== null && $this->patron->alive; }
	public function getPatron(): ?Character { return $this->patron; }
	public function setPatron(?Character $c): void { $this->patron = $c; }

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

	public function getNumBrothers(): int { return $this->brothers; }
	public function setNumBrothers(int $n): void {
		assert($n >= 0);
		$this->brothers = $n;
	}

	public function getNumSisters(): int { return $this->sisters; }
	public function setNumSisters(int $n): void {
		assert($n >= 0);
		$this->sisters = $n;
	}

	public function getNumSiblings(): int {
		return $this->brothers + $this->sisters;
	}

	public function pickRandomSibling(): ?string {
		if($this->brothers === 0 && $this->sisters === 0) return null;
		$r = Roll("d".($this->brothers + $this->sisters));
		if($r <= $this->brothers) {
			return 'Brother';
		} else {
			return 'Sister';
		}
	}

	public function getNumIllegitSiblings(): int { return $this->illegitSiblings; }
	public function setNumIllegitSiblings(int $n): void {
		assert($n >= 0);
		$this->illegitSiblings = $n;
	}

	public function getGender(): int { return $this->gender; }
	public function setGender(int $g): void {
		assert(in_array($g, [ self::MALE, self::FEMALE ], true));
		$this->gender = $g;
	}

	public function isAlive(): bool { return $this->alive; }
	public function kill(): void { $this->alive = false; }

	public function isEnslaved(): bool { return $this->enslaved; }
	public function setEnslaved(bool $e): void { $this->enslaved = $e; }

	public function isImprisoned(): bool { return $this->imprisoned; }
	public function setImprisoned(bool $i): void { $this->imprisoned = $i; }

	public function isEnlistedInMilitary(): bool { return $this->inmilitary; }
	public function setEnlistedInMilitary(bool $e): void { $this->inmilitary = $e; }

	public function getMilitaryRank(): int { return $this->militaryrank; }
	public function setMilitaryRank(int $r): void {
		assert($r === 0 || isset(self::MILITARY_RANKS[$r]));
		$this->militaryrank = $r;
	}
	public function promote(State $s): void {
		$s->pushActiveCharacter($this);
		if(isset(self::MILITARY_RANKS[$this->militaryrank + 1])) {
			LineAdder("And character gets promoted")($s);
			++$this->militaryrank;
			$s->invokeTable("538", new TrivialRoller(self::MILITARY_RANKS[$this->militaryrank][1]));
		}
		$s->popActiveCharacter();
	}
	public function demote(State $s): void {
		$s->pushActiveCharacter($this);
		if(isset(self::MILITARY_RANKS[$this->militaryrank - 1])) {
			LineAdder("And character gets demoted")($s);
			--$this->militaryrank;
			$s->invokeTable("538", new TrivialRoller(self::MILITARY_RANKS[$this->militaryrank][1]));
		}
		$s->popActiveCharacter();
	}

	public function getModifier(string $mod): int {
		assert(isset($this->modifiers[$mod]));
		return $this->modifiers[$mod];
	}

	public function setModifier(string $mod, int $v): void {
		assert(isset($this->modifiers[$mod]));
		$this->modifiers[$mod] = $v;
		trace("char", "setModifier: %s = %d", $mod, $v);
	}

	public function increaseModifier(string $mod, int $v): void {
		assert(isset($this->modifiers[$mod]));
		$this->modifiers[$mod] += $v;
		trace("char", "increaseModifier: %s += %d (now %d)", $mod, $v, $this->modifiers[$mod]);
	}

	public function getNumTraits(string $type): int {
		assert(isset($this->traits[$type]));
		return $this->traits[$type];
	}
	
	public function addTrait(string $type): void {
		assert(isset($this->traits[$type]));
		++$this->traits[$type];
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

	public function printPlaintextSummary(?int $len = null): void {
		static $prefix = '|   '; /* Per nesting level */
		static $cprefix = '+ '; /* If children are present */
		static $ncprefix = '| '; /* If no children */
		static $wprefix = '> '; /* For wrapped lines */

		if($len === null) {
			$len = min(160, max(80, intval(shell_exec('tput cols'))));
		}

		$modline = [];
		foreach($this->modifiers as $k => $v) {
			$modline[] = sprintf("%s: %+2d", $k, $v);
		}
		$modline = implode(", ", $modline);

		$hlen = $len - strlen($modline) - 3;
		printf("%-".$hlen.".".$hlen."s (%s)\n", $this->getName(), $modline);
		echo str_repeat("=", $len), "\n";

		$traverse = function(Entry $e, int $level) use($len, $prefix, $cprefix, $ncprefix, $wprefix, &$traverse) {
			$hprefix = $prefix = str_repeat($prefix, $level);
			if($e->getChildren() !== []) {
				$hprefix .= $cprefix;
				$prefix .= $ncprefix;
			}
			$hprefix .= ($s = $e->getSourceName().': ');
			$prefix .= str_repeat(' ', strlen($s));
			$hsuffix = sprintf("(%-5.5s)", $e->getSourceID());
			assert(strlen($hprefix) === strlen($prefix));

			$wlen = strlen($wprefix);
			$nhlen = $len - strlen($prefix);
			$hlen = $nhlen - strlen($hsuffix);
			assert($hlen > 0);

			$lines = $e->getLines();
			if($lines === []) $lines[] = '';
			$first = true;
			foreach($lines as &$l) {
				if($first === true) {
					$first = false;
					$l = explode("\n", wordwrap($l, $hlen, "\n"), 2);
					if(count($l) >= 2) {
						$l = array_merge(
							[ $l[0] ],
							explode("\n", wordwrap(str_replace("\n", " ", $wprefix.$l[1]), $nhlen - $wlen, "\n".$wprefix))
						);
					}
					continue;
				}
				$l = explode("\n", wordwrap($l, $nhlen - $wlen, "\n".$wprefix));
			}
			$lines = array_merge(...$lines);
			
			$first = true;
			foreach($lines as $line) {
				if($first) {
					$first = false;
					printf("%s%-".$hlen.".".$hlen."s%s\n", $hprefix, $line, $hsuffix);
				} else {
					printf("%s%-".$nhlen.".".$nhlen."s\n", $prefix, $line);
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

	public function markVisitedTableRange(string $id, string $range): void {
		$this->tableInfo[$id][$range] = true;
	}

	public function isTableRangeVisited(string $id, string $range): bool {
		return isset($this->tableInfo[$id][$range]);
	}

	public function forgetVisitedTableRange(?string $id, ?string $range): void {
		assert($id !== null || $range === null);
		if($range === null) {
			if($id === null) {
				$this->tableInfo = [];
				return;
			}

			unset($this->tableInfo[$id]);
			return;
		}

		unset($this->tableInfo[$id][$range]);
	}
}
