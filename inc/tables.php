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
	private $roller;
	private $actions; /* [ int $lo, int $hi, callable $payload ] */
	private $pc;

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
	
	public function __construct(Roller $roller, array $entries, PayloadCreator $pc) {
		$this->roller = $roller;		
		$this->actions = [];
		$this->pc = $pc;
		
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
				assert(is_string($e) || is_callable($e));

				if(is_string($e)) {
					$text = $e;
					$action = null;
				} else {
					$text = null;
					$action = $e;
				}
			}
		
			$this->actions[] = [ $lo, $hi, $this->pc->createPayload($text, $action) ];
		}

		usort($this->actions, function($a, $b) {
			return ($a[0] <=> $b[0]) ?: ($a[1] <=> $b[1]);
		});

		/* Make sure table has no holes or overlapping ranges */
		$phi = null;
		foreach($this->actions as [ $lo, $hi, ]) {
			assert($phi === null || $lo === $phi + 1);
			$phi = $hi;
		}
	}

	public function execute(State $s, ?Roller $roller = null, bool $combineRoll = false): void {
		if($combineRoll === true) {
			assert($roller !== null);
			$roll = $roller($s) + $this->roller->roll($s);
		} else {
			$roll = $roller ? $roller->roll($s) : $this->roller->roll($s);
		}

		assert(is_int($roll));
		
		foreach($this->actions as [ $lo, $hi, $payload ]) {
			if($roll < $lo || $roll > $hi) continue;

			$payload($s);
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

	public function __construct(string $id, string $name, Roller $roller, array $entries) {
		parent::__construct($roller, $entries, $this);
		
		assert(preg_match('%^[1-9][0-9]*[A-Z]*$%', $id));
		assert($name !== '');
		
		$this->id = $id;
		$this->name = $name;
	}
	
	public function createPayload(?string $text, ?callable $action): callable {
		assert($text !== null || $action !== null);

		return function(State $s) use($text, $action) {
			$sub = new Entry($this->id, $this->name, $text);
			
			$ch = $s->getActiveCharacter();
			$ch->getActiveEntry()->addChild($sub);
			
			if($action === null) return;
			
			$ch->setActiveEntry($sub);
			$newtext = $action($s);
			
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
	public function __construct(Roller $roller, array $entries) {
		parent::__construct($roller, $entries, $this);
	}

	public function createPayload(?string $text, ?callable $action): callable {
		assert($text !== null || $action !== null);

		return function(State $s) use($text, $action) {			
			$ch = $s->getActiveCharacter();
			$e = $ch->getActiveEntry();

			if($text !== null) $e->addLine($text);			
			if($action === null) return;
			
			$newtext = $action($s);
			
			if(is_string($newtext)) {
				if($newtext === '') $newtext = null;
				assert($e->replaceLine($text, $newtext) === true);
			} else {
				assert($newtext === null);
			}
		};
	}
}
