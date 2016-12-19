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
	public $SolMod = 0;
	public $LegitMod = 0;
	public $BiMod = 0;
	public $TiMod = 0;
	
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
	assert(file_exists($f));
	require $f;
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
