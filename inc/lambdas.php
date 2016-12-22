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
		$s->invoke(...$datas);
	};
}

function TableInvoker(string $data, ...$executeArgs): callable {
	return function(State $s) use($data, $executeArgs) {
		$s->invokeTable($data, ...$executeArgs);
	};
}

function ModifierIncreaser(string $k, int $v): callable {
	return function($s) use($k, $v) {
		$s->getActiveCharacter()->increaseModifier($k, $v);
	};
}

function Repeat(int $count, callable $action, ...$args): void {
	while(--$count >= 0) $action(...$args);
}

function Repeater(int $count, callable $action): callable {
	return function(...$args) use($count, $action) {
		Repeat($count, $action, ...$args);
	};
}

function SubtableInvoker(Roller $r, array $entries) {
	$anon = new AnonymousSubtable($r, $entries);
	return function(State $s) use($anon) {
		$anon->execute($s);
	};
}

function LineAdder(string $line) {
	return function(State $s) use($line) {
		$s->getActiveCharacter()->getActiveEntry()->addLine($line);
	};
}


/* XXX broken code below */

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

function EntryAdder(State $s, $entry, string $name = "", string $id = ""): callable {
	return function() use(&$s, $entry, $name, $id) {
		if($entry === null) return;
		assert(is_string($entry));
		$s->char->entries[] = [ $id, $name, $entry ];
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
