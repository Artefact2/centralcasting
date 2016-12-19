<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

class State {}

class Character {
	public $CuMod = 0;
	
	public $entries = [];
};

function Table(State $s, $id, $name, int $roll, array $entries) {	
	foreach($entries as $range => $e) {
		if(strpos($range, '-') !== false) {
			list($lo, $hi) = explode('-', $range, 2);
			if($lo === '') $lo = PHP_INT_MIN;
			if($hi === '') $hi = PHP_INT_MAX;

			if($roll < $lo || $roll > $hi) continue;
		} else {
			if($roll !== (int)$range) continue;
		}

		if(is_array($e)) {
			list($e, $action) = $e;
		} else {
			$action = null;
		}

		$entry = [ $id, $name, $e ];
		
		if(is_string($e)) $s->char->entries[] =& $entry;
		if(is_callable($action)) {
			$ret = $action();
			if(is_string($ret)) {
				$entry[2] = $ret;
			}
		}
		
		return;
	}

	assert(false);
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
	require __DIR__.'/data/'.$dataref.'.php';
}

function PrintCharacterEntries(Character $c) {
	foreach($c->entries as $e) {
		printf("(%-4s) %30s: %s\n", $e[0], $e[1], $e[2]);
	}
}

function EditCharacter(Character $c, $id, $newval) {
	foreach($c->entries as &$e) {
		if($e[0] === $id) {
			$e[2] = $newval;
			return;
		}
	}

	assert(false);
}