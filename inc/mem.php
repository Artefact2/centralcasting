<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;

abstract class InstanceCounter {
	private static $numinst = [];
	private static $maxinst = [];

	protected function __construct() {
		$k = get_class($this);

		self::$numinst[$k] = (self::$numinst[$k] ?? 0) + 1;
		if(self::$maxinst[$k] ?? 0 < self::$numinst[$k]) {
			self::$maxinst[$k] = self::$numinst[$k];
		}
		
		trace('mem', 'constructed %s "%s" %s (%d/%d instances)',
		      $k, $this->id ?? $this->name ?? '', spl_object_hash($this),
		      self::$numinst[$k], self::$maxinst[$k]);
	}

	protected function __destruct() {
		--self::$numinst[$k = get_class($this)];
		trace('mem', 'destroyed %s "%s" %s', $k, $this->id ?? $this->name ?? '', spl_object_hash($this));
	}
}
