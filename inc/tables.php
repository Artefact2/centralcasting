<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;

interface RandomExecutor {
	public function execute(State $s, ?Roller $roller = null, bool $combineRoll = false): void;
	public function executeAll(State $s): void;
}

interface PayloadCreator {
	public function createPayload(?string $text, ?callable $action): callable;
}

class RandomTable implements RandomExecutor {
	private $id;
	private $roller;
	private $actions; /* [ string $range, int $lo, int $hi, callable $payload ] */
	private $pc;
	private $posthooks;

	const REROLL_DUPLICATES = 1;
	
	private $flags;

	public static function parseRange(string $range): array {
		if(strpos($range, '-') !== false) {
			list($lo, $hi) = explode('-', $range, 2);
			if($lo === '') $lo = PHP_INT_MIN;
			if($hi === '') $hi = PHP_INT_MAX;

			/* XXX: this is very ugly */
			if(is_string($lo) && $lo[0] === 'm') $lo = -intval(substr($lo, 1));
			if(is_string($hi) && $hi[0] === 'm') $hi = -intval(substr($hi, 1));

			assert($lo <= $hi);
			return [ (int)$lo, (int)$hi ];
		}
		
		if(is_string($range) && $range[0] === 'm') $range = -intval(substr($range, 1));
		return [ (int)$range, (int)$range ];
	}
	
	public function __construct(string $id, Roller $roller, array $entries, PayloadCreator $pc, int $flags = 0) {
		$this->id = $id;
		$this->roller = $roller;		
		$this->actions = [];
		$this->pc = $pc;
		$this->posthooks = [];
		$this->flags = $flags;
		
		foreach($entries as $range => $e) {
			list($lo, $hi) = self::parseRange($range);
			
			if(is_array($e)) {
				assert(is_string($e[0]) || $e[0] === null);
				if(count($e) === 1) {
					$e = $e[0];
				} else {					
					assert(count($e) === 2 && is_callable($e[1]));

					if($e[0] === null) {
						$e = $e[1];
					} else {
						list($text, $action) = $e;
					}
				}
			}

			if(!is_array($e)) {
				if(is_string($e)) {
					$text = $e;
					$action = null;
				} else if(is_callable($e)) {
					$text = null;
					$action = $e;
				} else {
					$text = $action = null;
				}
			}

			$payload = $this->pc->createPayload($text, $action);
			$this->actions[] = [ $range, $lo, $hi, function(State $s, int $roll) use($payload) {
					$payload($s, $roll);
					foreach($this->posthooks as $ph) {
						$ph($s, $roll);
					}
				}];
		}

		usort($this->actions, function($a, $b) {
			return ($a[1] <=> $b[1]) ?: ($a[2] <=> $b[2]);
		});

		/* Make sure table has no holes or overlapping ranges */
		$phi = null;
		foreach($this->actions as [ , $lo, $hi, ]) {
			assert($phi === null || $lo === $phi + 1);
			$phi = $hi;
		}
	}

	public function addPostExecuteHook(callable $c) { $this->posthooks[] = $c; }

	public function execute(State $s, ?Roller $roller = null, bool $combineRoll = false): void {
		if($combineRoll === true) {
			assert($roller !== null);
			$roll = $roller->roll($s) + $this->roller->roll($s);
		} else {
			$roll = $roller ? $roller->roll($s) : $this->roller->roll($s);
		}

		assert(is_int($roll));
		
		foreach($this->actions as [ $range, $lo, $hi, $payload ]) {
			if($roll < $lo || $roll > $hi) continue;

			if($this->flags & self::REROLL_DUPLICATES) {
				if($s->getActiveCharacter()->isTableRangeVisited($this->id, $range)) {
					$this->execute($s, $roller, $combineRoll);
					return;
				}
			}

			$s->getActiveCharacter()->markVisitedTableRange($this->id, $range);
			$payload($s, $roll);
			return;
		}

		assert(false);
	}

	public function executeAll(State $s): void {
		/* TODO */
	}
}

class NamedTable extends RandomTable implements PayloadCreator {
	private $id;
	private $name;

	public function __construct(string $id, string $name, Roller $roller, array $entries, int $flags = 0) {
		parent::__construct($id, $roller, $entries, $this, $flags);
		
		assert(preg_match('%^[1-9][0-9]*[A-Z]*$%', $id));
		assert($name !== '');
		
		$this->id = $id;
		$this->name = $name;
	}
	
	public function createPayload(?string $text, ?callable $action): callable {
		return function(State $s, int $roll) use($text, $action) {
			$sub = new Entry($this->id, $this->name, $text);
			
			$ch = $s->getActiveCharacter();
			$ch->getActiveEntry()->addChild($sub);
			
			if($action === null) return;
			
			$ch->setActiveEntry($sub);
			$newtext = $action($s, $roll);
			
			if(is_string($newtext)) {
				if($newtext === '') $newtext = null;
				assert($sub->replaceLine($text, $newtext) === true);
			} else {
				assert($newtext === null);
			}
			$ch->setActiveEntry($sub->getParent());
		};
	}
}

class AnonymousSubtable extends RandomTable implements PayloadCreator {
	public function __construct(Roller $roller, array $entries, int $flags = 0) {
		parent::__construct(sprintf("Anon%9.9d", mt_rand()), $roller, $entries, $this, $flags);
	}

	public function createPayload(?string $text, ?callable $action): callable {
		return function(State $s, int $roll) use($text, $action) {			
			$ch = $s->getActiveCharacter();
			$e = $ch->getActiveEntry();

			if($text !== null) $e->addLine($text);			
			if($action === null) return;
			
			$newtext = $action($s, $roll);
			
			if(is_string($newtext)) {
				if($newtext === '') $newtext = null;
				assert($e->replaceLine($text, $newtext) === true);
			} else {
				assert($newtext === null);
			}
		};
	}
}
