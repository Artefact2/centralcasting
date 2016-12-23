<?php

namespace HeroesOfLegend;

return new NamedTable("215B", "Family Change Event", DiceRoller::from("d6"), [
	"1" => [ "Change culture level", function(State $s) {
		$ac = $s->getActiveCharacter();
		$orig = $ac->getModifier('CuMod');

		while(true) {
			$ac->setModifier('CuMod', 0);
			$s->invoke("102");

			if($ac->getModifier('CuMod') === $orig) {
				$ch = $ac->getActiveEntry()->getChildren();
				assert($ac->getActiveEntry()->removeChild(array_pop($ch)) === true);
				continue;
			}

			break;
		}
	}],
	"2" => [ "Change social status", function(State $s) {
		$ac = $s->getActiveCharacter();
		$orig = $ac->getModifier('SolMod');

		while(true) {
			$ac->setModifier('SolMod', 0);
			$s->invoke("103");

			if($ac->getModifier('SolMod') === $orig) {
				$ch = $ac->getActiveEntry()->getChildren();
				assert($ac->getActiveEntry()->removeChild(array_pop($ch)) === true);
				continue;
			}

			break;
		}
	}],
	"3" => "Change locale (relative distance: ".Roll("d10")."/10)",
	"4" => [ "Head of household changes occupation", Invoker("420-423") ],
	"5" => [ "Parents split up", function(State $s) {
		$ac = $s->getActiveCharacter();
		if(!$ac->hasMother() || !$ac->hasFather()) {
			$s->invoke("215B");
			return '';
		}

		Combiner(
			LineAdder("Character goes with ".(Roll("d2") === 1 ? 'mother' : 'father')),
			LineAdder(Roll("d6") <= 4 ? "Mother remarries within ".Roll("d3")." year(s)" : null),
			LineAdder(Roll("d6") <= 4 ? "Father remarries within ".Roll("d3")." year(s)" : null)
		)($s);
	}],
	"6" => Repeater(2, Invoker("215B")),
], RandomTable::REROLL_DUPLICATES);
