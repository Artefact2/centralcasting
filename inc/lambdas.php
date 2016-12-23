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

function SubtableInvoker(Roller $r, array $entries, ?int $flags = 0, &$outTable = null): callable {
	$outTable = new AnonymousSubtable($r, $entries, $flags);
	return function(State $s) use($outTable) {
		$outTable->execute($s);
	};
}

function LineAdder(?string $line): callable {
	return function(State $s) use($line) {
		$s->getActiveCharacter()->getActiveEntry()->addLine($line);
	};
}

function SubentryCreator(string $id, string $name, ?string $text, callable ...$actions) {
	return function(State $s) use($id, $name, $text, $actions) {
		$sub = new Entry($id, $name, $text);
		$ac = $s->getActiveCharacter();
		$ac->getActiveEntry()->addChild($sub);
		$ac->setActiveEntry($sub);

		foreach($actions as $action) $action($s);
		
		$ac->setActiveEntry($sub->getParent());
	};
}

function TraitAdder(string $type): callable {
	return function(State $s) use($type) {
		$s->getActiveCharacter()->addTrait($type);
	};
}

function RandomTrait(): callable {
	return TraitAdder('R');
}

function LightsideTrait(): callable {
	return TraitAdder('L');
}

function DarksideTrait(): callable {
	return TraitAdder('D');
}

function NeutralTrait(): callable {
	return TraitAdder('N');
}

function CharacterSandboxer(bool $moveEntries, &$puppet, callable ...$actions): callable {
	return function(State $s) use($actions, $moveEntries, &$puppet) {
		$puppet = Character::PC("Sandboxed Puppet");
		$s->pushActiveCharacter($puppet);
		foreach($actions as $a) $a($s);
		$s->popActiveCharacter($puppet);
		if($moveEntries) {
			$ae = $s->getActiveCharacter()->getActiveEntry();
			foreach($puppet->getRootEntry()->getChildren() as $pe) {
				$ae->addChild($pe);
			}
		}
	};
}
