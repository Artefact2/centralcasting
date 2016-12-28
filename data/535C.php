<?php

namespace HeroesOfLegend;

return new NamedTable("535C", "Battle Outcome", new DiceRoller("d20-d20"), [
	"-" => function(State $s, int $r) {
		$ac = $s->getActiveCharacter();

		if($ac->getMilitaryRank() >= 8) {
			$r += min(3, $ac->getModifier('ViMod'));
		}

		$s->invokeTable("535D", new TrivialRoller($r));

		if($r > 0) {
			$ac->increaseModifier('ViMod', 1);
			return "Character's side won";
		} else if($r < 0) {
			return "Character's side lost";
		} else {
			return "Both sides were forced from the field with no winner";
		}
	}
]);
