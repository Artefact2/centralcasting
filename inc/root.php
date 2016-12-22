<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_BAIL, 1);

require __DIR__.'/state.php';
require __DIR__.'/character.php';
require __DIR__.'/entries.php';
require __DIR__.'/tables.php';
require __DIR__.'/lambdas.php';
require __DIR__.'/roller.php';

/* XXX broken code below */

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
				if(is_string($range) && $range[0] === 'm') $range = -intval(substr($range, 1));
				
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
