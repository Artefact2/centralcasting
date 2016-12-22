<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;


function Combiner(callable ...$lambdas): callable {
	return function(...$args) use($lambdas) {
		foreach($lambdas as $l) $l(...$args);
	};
}

function Invoker(string ...$datas): callable {
	return function(State $s) use($datas) {
		$s->invokeTables(...$datas);
	};
}




/* XXX broken code below */

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
