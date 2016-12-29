<?php

namespace HeroesOfLegend;

return new NamedTable("530", "Elven Event", new DiceRoller("d10"), [
	"1" => [ "Forest home ravaged by monsters (no casualties)",
	         LineAdder("But it will be centuries before woodlands are restored to normal") ],
	"2" => [ "Character is given magical bow by someone he knows (GM decides magical powers)", Invoker("750") ],
	"3" => "Character is given special soul tree (+1 Strength, Constitution, Magical ability as long as tree is thriving)",
	"4" => function(State $s) {
		if($s->getActiveCharacter()->getNumSiblings() > 0) {
			return "At least one sibling is a half-elf";
		}

		$s->invoke("530");
		return '';
	},
	"5" => [ "Character acquires unusual pet (type of animal is always one of the forest)", Invoker("759") ],
	"6" => [ "Character was found as an adult, possibly 100+ years old in time-worn clothes next to a giant tree",
	         LineAdder("And character has no knowledge of true name, past or skills") ],
	"7" => "Character is cursed with human mortality (quest may remove curse, GM decides)",
	"8" => "Character's family adopts a young human",
	"9" => "Character gains 5 ranks in storytelling and singing",
	"10" => "Character learns ".Roll("d3")." language(s) at rank 4 from ancient hermit",
]);
