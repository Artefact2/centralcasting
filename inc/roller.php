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
	private $func; /* Callable(?State) */

	public static function validateSpec(string $spec): bool {
		$ret = preg_match(
			'%
            ^(
              (?<term>
                (?<ndice>[1-9][0-9]*)?(d|D)(?<nsides>[1-9][0-9]*)
                |(?<modifier>[A-Z][A-Za-z]+Mod)
                |(?<const>0|[1-9][0-9]*)
              )(?<op>\+|-|\*|$)
            )+
            $%x',
			$spec
		);

		assert($ret === 0 || $ret === 1);
		return (bool)$ret;
	}

	public static function from(string $dicespec): DiceRoller {
		fixme('roller', 'DiceRoller::from() is deprecated');
		return new self($dicespec);
	}

	public function __construct(string $dicespec) {
		$funcs = [];

		assert(self::validateSpec($dicespec));
		$parts = preg_split('%(\+|-|\*)%', $dicespec, -1, PREG_SPLIT_DELIM_CAPTURE);
		array_unshift($parts, '+');

		while($parts !== []) {
			$op = array_shift($parts);
			$term = array_shift($parts);

			if(ctype_digit($term)) {
				$term = (int)$term;
				$getval = function() use($term) { return $term; };
			} else if(preg_match('%^(?<modifier>[A-Z][A-Za-z]+Mod)$%', $term, $match)) {
				$mod = $match['modifier'];
				$getval = function(?State $s) use($mod) {
					return $s->getActiveCharacter()->getModifier($mod);
				};
			} else if(preg_match('%^(?<ndice>[1-9][0-9]*)?(d|D)(?<nsides>[1-9][0-9]*)$%', $term, $match)) {
				$ndice = $match['ndice'] ? (int)$match['ndice'] : 1;
				$nsides = (int)$match['nsides'];
				assert($ndice >= 0 && $nsides >= 1);
				$getval = function() use($ndice, $nsides) {
					$s = 0;
					while(--$ndice >= 0) $s += 1 + (mt_rand() % $nsides);
					return $s;
				};
			} else {
				assert(false);
			}

			assert(is_callable($getval));
			$funcs[] = function(?State $s, int $accum) use($op, $getval): int {
				switch($op) {
				case '+':
				return $accum + $getval($s);

				case '-':
				return $accum - $getval($s);

				case '*':
				return $accum * $getval($s);
				}

				assert(false);
			};
		}

		$this->func = function(?State $s) use($funcs): int {
			$acc = 0;
			foreach($funcs as $f) $acc = $f($s, $acc);
			return $acc;
		};
	}

	public function roll(?State $s = null): int {
		return ($this->func)($s);

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
