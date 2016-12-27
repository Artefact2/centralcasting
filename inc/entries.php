<?php
/* Author: Romain Dal Maso <artefact2@gmail.com>
 *
 * This program is free software. It comes without any warranty, to the
 * extent permitted by applicable law. You can redistribute it and/or
 * modify it under the terms of the Do What The Fuck You Want To Public
 * License, Version 2, as published by Sam Hocevar. See
 * http://sam.zoy.org/wtfpl/COPYING for more details. */

namespace HeroesOfLegend;

class Entry {
	private $sourceID;
	private $sourceName;
	private $lines = []; /* string[], no newlines */

	private $parent = null;
	private $children = [];

	public function __construct(string $id, string $name, $line = null) {		
		$this->sourceID = $id;
		$this->sourceName = $name;

		if($line !== null) $this->addLine($line);
	}

	public function replaceLine(?string $old, ?string $new): bool {
		if($old === null) {
			$this->addLine($new);
			return true;
		}
		
		foreach($this->lines as $k => &$val) {
			if($val === $old) {
				if($new !== null) $val = $new;
				else unset($this->lines[$k]);
				
				return true;
			}
		}

		return false;
	}

	public function findAndReplaceLines(string $id, array $newlines): ?array {
		if($this->sourceID === $id) {
			$oldlines = $this->lines;
			$this->lines = $newlines;
			return $oldlines;
		}

		foreach($this->children as $c) {
			if(($oldlines = $c->findAndReplaceLines($id, $newlines)) !== null) {
				return $oldlines;
			}
		}

		return null;
	}

	public function findDescendantByID(string $id): ?Entry {
		if($this->sourceID === $id) {
			return $this;
		}

		foreach($this->children as $c) {
			if(($e = $c->findDescendantByID($id)) !== null) return $e;
		}

		return null;
	}

	public function addLine(?string $line): void {
		if($line === null) return;
		
		assert(strpos($line, "\n") === false);
		$this->lines[] = $line;
	}

	public function addChild(Entry $child): void {
		if(($parent = $child->getParent()) !== null) {
			assert($parent->removeChild($child) === true);
		}
		
		$child->setParent($this);
		$this->children[] = $child;
	}

	public function removeChild(Entry $child): bool {
		foreach($this->children as $k => $c) {
			if($c === $child) {
				unset($this->children[$k]);
				return true;
			}
		}
		
		return false;
	}

	public function getSourceID(): string { return $this->sourceID;	}
	public function getSourceName(): string { return $this->sourceName;	}

	public function getLines(): array {
		/* Arrays are passed by value */
		return $this->lines;
	}

	public function getParent(): ?Entry { return $this->parent;	}
	public function setParent(?Entry $p): void { $this->parent = $p; }

	public function getChildren(): array { return $this->children; }
	public function getNeighbors(): array {
		if($this->parent === null) return [ $this ];
		return $this->parent->getChildren();
	}
	public function getLatestChild(): ?Entry { return end($this->children); }

	public function isEmpty(): bool {
		return $this->children === [] && $this->lines === [];
	}

	public function isTrivial(): bool {
		return $this->lines === [];
	}

	public function prune(): void {
		foreach($this->children as $c) $c->prune();
		if($this->parent === null) return;

		if($this->isTrivial()) {
			$canprune = true;
			
			foreach($this->children as $c) {
				if($c->getSourceID() !== $this->getSourceID()) {
					$canprune = false;
					break;
				}
			}

			if($canprune) {
				foreach($this->children as $c) {
					$this->parent->addChild($c);
				}
				
				assert($this->isEmpty());
			}
		}
		
		if($this->isEmpty()) {
			assert($this->parent->removeChild($this) === true);
			return;
		}
	}
}
