<?php

namespace HeroesOfLegend;

return new NamedTable("760", "Special Pet Ability", new DiceRoller("d20"), [
	"1" => "Pet has wings (or an extra set of wings)",
	"2" => "Pet is very intelligent (better than average human)", function(State $s) {
		if(Roll("d100") <= 60) {
			LineAdder("And pet can speak an understandable language")($s);
		}
	},
	"3" => "Pet is telepathic (can communicate by mental speech)",
	"4" => [ "Pet has unusual color", Invoker("865") ],
	"5" => [ "Pet is made of weird substance, not flesh and blood", SubtableInvoker(new DiceRoller("d10"), [
		"1-2" => "Stone (granite, marble, etc.)",
		"3-4" => "Wood",
		"5" => "Precious metal (with gems for eyes)",
		"6" => "Cloth (like a stuffed animal)",
		"7" => "Precious stone (gemstone)",
		"8" => "Iron",
		"9" => "Bronze",
		"10" => [ "Multiple materials",
		          Repeater(2, function(State $s) use(&$subst) { $subst->execute($s, new DiceRoller("d9")); }) ],
	], RandomTable::REROLL_DUPLICATES, $subst)],
	"6" => [ "Pet has physical affliction", Invoker("874") ],
	"7" => "Pet can use magic spells",
	"8" => "Pet is naturally invisible to all but owner (other will think pet is imaginary)",
	"9" => "Pet regenerates damage done to it",
	"10" => [ "Upon death, pet's spirit will possess nearest animal and keep powers/features",
	          LineAdder("But has 35% risk of adopting a new owner") ],
	"11" => function() {
		return Roll("d2") === 1 ? "Pet is unusually large (even gigantic)" : "Pet is unusually small (even miniature)";
	},
	"12" => "Pet can turn into an attractive human (once per day for d6 hours)",
	"13" => "Pet draws d4 magic ability attribute points from its master daily to survive",
	"14" => "Pet supplies magical power to its master (like a battery)",
	"15" => "Pet's life energy (HP) added to owner's as long as the pet lives",
	"16" => "Pet breathes fire (d6 damage)",
	"17" => "Pet can increase size and strength d10 times normal value (once per day for d6 hours)",
	"18" => "Pet can provide master with d6 gold coins (once per day)",
	"19" => "Pet can discorporate into mist at will",
	"20" => function(State $s) {
		$s->getActiveCharacter()->forgetVisitedTableRange("760", null);
		Repeater(Roll("d3"), Invoker("760"))($s);
		return "More special abilities (discard any after fourth)";
	}
], RandomTable::REROLL_DUPLICATES);
