<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;

class State {
	private $rootChar; /* Character */
	private $activeCharStack; /* Character[] */

	public function __construct(Character $root) {
		$this->rootChar = $root;
		$this->activeCharStack = [ $this->rootChar ];
	}

	public function getRootCharacter(): Character {
		return $this->rootChar;
	}

	public function getActiveCharacter(): Character {
		return end($this->activeCharStack);
	}

	public function pushActiveCharacter(Character $c): void {
		$this->activeCharStack[] = $c;
	}

	public function popActiveCharacter(): Character {
		$c = array_pop($this->activeCharStack);
		assert($c !== false && $this->activeCharStack !== []);
		return $c;
	}

	private function genericInvoke(callable $action, string ...$datas): void {
		foreach($datas as $data) {
			$f = __DIR__.'/../data/'.$data.'.php';
			if(!file_exists($f)) {
				fprintf(STDERR, "WARNING: script %s not implemented\n", $data);
				continue;
			}

			$action($f);
		}
	}

	public function invoke(string ...$datas): void {
		$this->genericInvoke(function($f) {
			$s = $this;
			$ret = require $f;
			if($ret instanceof RandomExecutor) {
				$ret->execute($this);
			}
		}, ...$datas);
	}

	public function invokeTable(string $data, ...$executeArgs): void {
		$this->genericInvoke(function($f) use($executeArgs) {
			$s = $this;
			$table = require $f;
			assert($table instanceof RandomExecutor);
			$table->execute($this, ...$executeArgs);
		}, $data);
	}
}
