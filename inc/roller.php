<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;

interface Roller {
	public function roll(?State $s = null): int;
}

class DiceRoller implements Roller {
	private $ndice;
	private $nsides;
	private $modifiers;

	public function __construct(int $ndice, int $nsides, array $modifiers = []) {
		assert($ndice >= 0);
		assert($nsides >= 1);
		
		$this->ndice = $ndice;
		$this->nsides = $nsides;
		$this->modifiers = $modifiers;
	}

	public static function from(string $dicespec): DiceRoller {		
		$ret = preg_match(
			'%^(?<ndice>[1-9][0-9]*)?(d|D)(?<nsides>[1-9][0-9]*)(?<modifiers>((\+|-|\*)([A-Z][A-Za-z]+Mod|[1-9][0-9]*))*)?$%',
			$dicespec, $match
		);
		assert($ret === 1);

		$modifiers = [];
		if($match['modifiers'] !== '') {
			$parts = preg_split('%(\+|-|\*)%', $match['modifiers'], null, PREG_SPLIT_DELIM_CAPTURE);
			array_shift($parts);

			while($parts !== []) {
				$op = array_shift($parts);
				$val = array_shift($parts);
				if(ctype_digit($val)) $val = (int)$val;
				$modifiers[] = [ $op, $val ];
			}
		}

		return new self((int)$match['ndice'] ?: 1, (int)$match['nsides'], $modifiers);
	}

	public function roll(?State $s = null): int {
		$total = 0;
		for($i = 0; $i < $this->ndice; ++$i) {
			$total += 1 + (mt_rand() % $this->nsides);
		}
		foreach($this->modifiers as [ $op, $mod ]) {
			if(is_string($mod)) {
				assert($s !== null);
				$mod = $s->getActiveCharacter()->getModifier($mod);
			}

			switch($op) {
			case '+':
				$total += $mod;
				break;

			case '-':
				$total -= $mod;
				break;

			case '*':
				$total *= $mod;
				break;

			default:
				assert(false);
			}
		}

		return $total;
	}
}

class RerollFilter implements Roller {
	private $roller;
	private $filter;
	
	public function __construct(Roller $roller, callable $filter) {
		$this->roller = $roller;
		$this->filter = $filter;
	}

	public function roll(?State $s = null): int {
		do {
			$roll = $this->roller->roll($s);
		} while(($this->filter)($roll) === false);
		return $roll;
	}
}

class TrivialRoller implements Roller {
	private $val;
	
	public function __construct(int $val) {
		$this->val = $val;
	}

	public function roll(?State $s = null): int {
		return $this->val;
	}
}

/* Just syntactic sugar */
function Roll(string $dicespec, ?State $s = null): int {
	return DiceRoller::from($dicespec)->roll($s);
}
