<?php

namespace HeroesOfLegend;

return new NamedTable("531", "Dwarvish Event", new DiceRoller("d10"), [
	"1" => "Character grows to undwarvish height",
	"2" => "Character is unable to grow beard",
	"3" => [ "Character receives odd gift from unnamed source", Invoker("863") ],
	"4" => [ "Character is given magical hammer by someone he knows (GM decides magical powers)", Invoker("750") ],
	"5" => [ "Character stumbles upon lost dwarvish caverns, full of lost lore, treasure and wondrous devices",
	         LineAdder("But upon leaving, character is unable to find his way back and no one believes him/her") ],
	"6" => [ "Monster raid forces character's family to leave home caverns", Combiner(
		LineAdder("And the monsters still occupy the cavern today"),
		function(State $s) {
			if(Roll("d6") >= 5) {
				LineAdder("And raid occured during character's lifetime")($s);
			} else {
				LineAdder("And raid occured a long time ago (before character was born)")($s);
			}
		}
	)],
	"7" => "Character's family adopts young human",
	"8" => [ "Character befriends a goblin (arch enemy of dwarves)", function(State $s) {
		if(Roll("d6") === 6) {
			LineAdder("And goblin becomes companion")($s);
			$s->invoke("761"); /* XXX 761A might be too much */
		}
	}],
	"9" => [ "Character discovers trove of mineral wealth", function(State $s) {
		$ac = $s->getActiveCharacter();
		$sm = $ac->getModifier('SolMod');
		if($sm < 4) {
			LineAdder("And character raises to Wealthy social status")($s);
			$ac->setModifier('SolMod', 4);
		}

		LineAdder("But wealth is taken away within ".Roll("d4")." year(s) by powerful monster")($s);
		$drop = Roll("d3");
		LineAdder("And character's social status drops by ".$drop." level(s)")($s);
		$ac->increaseModifier('SolMod', -2 * $drop);
	}],
	"10" => [ "Character receives training from dwarven home guard",
	          LineAdder("Learn usage of warhammer, sword and shield at rank 4") ],
]);
