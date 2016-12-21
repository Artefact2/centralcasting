<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_BAIL, 1);

class State {
	public $char;

	public function __construct() {
		$this->char = new Character();
	}
}

class Character {
	const PC = 0;
	const NPC = 1;

	const CHILD = 0;
	const ADOLESCENT = 1;
	const ADULT = 2;
	
	public $type = self::PC;
	public $ageRange = self::CHILD;
	
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
	public $entries = [];
};

const TABLE_REROLL_DUPLICATES = 1;

function Table(State $s, $id, $name, $roll, array $entries, int $flags = 0) {
	assert(is_callable($roll) || is_numeric($roll));
	assert(!($flags & TABLE_REROLL_DUPLICATES) || is_callable($roll));

	$origroll = $roll;
	
	while(true) {
		if(is_callable($origroll)) {
			$roll = $origroll();
		}
		
		foreach($entries as $range => $e) {
			if(strpos($range, '-') !== false) {
				list($lo, $hi) = explode('-', $range, 2);
				if($lo === '') $lo = PHP_INT_MIN;
				if($hi === '') $hi = PHP_INT_MAX;

				/* XXX: this is very ugly */
				if(is_string($lo) && $lo[0] === 'm') $lo = -intval(substr($lo, 1));
				if(is_string($hi) && $hi[0] === 'm') $hi = -intval(substr($hi, 1));

				if($roll < $lo || $roll > $hi) continue;
			} else {
				if($roll !== (int)$range) continue;
			}

			if(($flags & TABLE_REROLL_DUPLICATES) && isset($s->char->_table[$id][$range])) {
				/* XXX potential infinite loop if all options have been taken */
				continue 2;
			}

			$s->char->_table[$id][$range] = true;

			if(is_array($e)) {
				list($e, $action) = $e;
			} else {
				$action = null;
			}

			$entry = [ $id, $name, $e ];
			$s->char->entries[] =& $entry;
			
			if(is_callable($action)) {
				$ret = $action();
				if(is_string($ret)) {
					$entry[2] = $ret;
				}
			}
		
			return;
		}

		fprintf(STDERR, "WARNING: table %s is incomplete, got roll %d\n", $id, $roll);
		assert(false);
	}
}

function TableForgetRerollInfo(State $s, $id = null, $range = null) {
	if($range === null) {
		if($id === null) {
			unset($s->char->_table);
			return;
		}
		
		unset($s->char->_table[$id]);
		return;
	}

	unset($s->char->_table[$id][$range]);
}

function Roll($n, $sides = null) {
	if($sides === null) {
		$sides = $n;
		$n = 1;
	}
	
	$r = 0;

	assert($n >= 0);
	assert($sides >= 1);

	for($i = 0; $i < $n; ++$i) {
		$r += 1 + (mt_rand() % $sides);
	}

	return $r;
}

function Invoke(State $s, $dataref) {	
	$f = __DIR__.'/data/'.$dataref.'.php';
	if(!file_exists($f)) {
		fprintf(STDERR, "WARNING: data %s not implemented\n", $dataref);
		return;
	}
	require $f;
}

function PrintCharacterEntries(Character $c) {
	foreach($c->entries as $e) {
		if($e[2] === null) continue;
		printf("(%-4s) %30.30s: %s\n", $e[0], $e[1], $e[2]);
	}
}

function EditCharacter(Character $c, $id, $newval) {
	foreach($c->entries as &$e) {
		if($e[0] === $id) {
			$e[2] = $newval;
			return;
		}
	}

	fprintf(STDERR, "WARNING: couldn't find key %s in character\n", $id);
	assert(false);
}

/* XXX handle duplicates */
function GetCharacterValue(Character $c, $id, $default = null) {
	foreach($c->entries as $e) {
		if($e[0] === $id) {
			return $e[2];
		}
	}

	return $default;
}

function Combiner(callable ...$lambdas): callable {
	return function() use($lambdas) {
		foreach($lambdas as $l) $l();
	};
}

function Invoker(State $s, $dataref): callable {
	return function() use(&$s, $dataref) {
		Invoke($s, $dataref);
	};
}

function CharIncrementer(State $s, $k, $v): callable {
	return function() use(&$s, $k, $v) {
		$s->char->$k += $v;
	};
}

function TableReroller(State $s, callable $table, callable $roller = null, int $count = 1, array $avoid = []): callable {
	assert($count >= 0);
	assert($roller !== null || $avoid === []);

	return function() use(&$s, $table, $roller, $count, $avoid) {
		while(--$count >= 0) {
			if($roller !== null) {
				do {
					$roll = $roller();
				} while(in_array($roll, $avoid, true));
			
				$table($roll);
			} else {
				$table();
			}
		}
	};
}

function Roller($n, $sides = null, $plusmod = 0): callable {
	return function() use($n, $sides, $plusmod) {
		return Roll($n, $sides) + $plusmod;
	};
}

function EntryAdder(State $s, $entry, string $name = "", string $id = ""): callable {
	return function() use(&$s, $entry, $name, $id) {
		if($entry === null) return;
		assert(is_string($entry));
		$s->char->entries[] = [ $id, $name, $entry ];
	};
}

function Repeater($count, callable $action): callable {
	if(is_callable($count)) $count = $count();
	assert(is_int($count) && $count >= 0);
	return function() use($count, $action) {
		while(--$count >= 0) $action();
	};
}

function TraitAdder(State $s, string $type): callable {
	return function() use(&$s, $type) {
		++$s->char->traits[$type];
	};
}

function RandomTrait(State $s): callable {
	return TraitAdder($s, 'R');
}

function LightsideTrait(State $s): callable {
	return TraitAdder($s, 'L');
}

function DarksideTrait(State $s): callable {
	return TraitAdder($s, 'D');
}

function NeutralTrait(State $s): callable {
	return TraitAdder($s, 'N');
}
