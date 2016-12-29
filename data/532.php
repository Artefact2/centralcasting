<?php

namespace HeroesOfLegend;

return new NamedTable("532", "Halfling Event", new DiceRoller("d10"), [
	"1" => [ "Character finds mysterious, dust-covered box in cluttered storeroom", Combiner(
		LineAdder("But no indication of where it came from"),
		Invoker("863")
	)],
	"2" => [ "Character wins skill contest and is widely renowned for it (gain rank 5 proficiency):",
	         SubtableInvoker(new DiceRoller("d6"), [
		         "1" => "Cooking",
		         "2" => "Archery",
		         "3" => "Slinging stones",
		         "4" => "Singing",
		         "5" => "Farming",
		         "6" => "Story telling",
	         ])],
	"3" => [ "Character's hospitality is strained by strange visitors", Combiner(
		LineAdder("Visitors spent the night telling tales of mystery and adventure and left something behind"),
		Invoker("863")
	)],
	"4" => [ "Family business fails, family must seek new home, social status drops one level", function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->getModifier('SolMod') >= 0) {
			$ac->increaseModifier('SolMod', -2);
		} else {
			$s->invoke("532");
			return '';
		}
	}],
	"5" => [ "Character stumbles upon tumbledown mansion in the woods, containing lost lore, treasure and wine cellar",
	         LineAdder("But he/she can't find his/her way back, and no one believes his/her stories") ],
	"6" => "Character becomes fat (10% penalty on Dexterity skill rolls until character loses weight)",
	"7" => [ "Character goes into huge debt to throw extravagant birthday party for him/herself",
	         LineAdder("Debt is still unpaid today and has grown to 2x amount borrowed") ],
	"8" => [ "Freeloading relatives move into character's home",
	         LineAdder("But according to custom, character cannot refuse or evict them") ],
	"9" => "Character learns to speak elvish (rank 4 proficiency)",
	"10" => "Character receives training from halfling militia, gain archery and club proficiency (rank 4)",
]);
