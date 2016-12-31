<?php

namespace HeroesOfLegend;

return new NamedTable("215", "Significant Event of Childhood & Adolescence", DiceRoller::from("d20+SolMod"), [
	"m2" => [ "Country is at war, riots in streets", function(State $s) {
		if($s->getActiveCharacter()->getModifier('CuMod') <= -2) {
			$s->invoke("215");
			return '';
		}

		LineAdder("All public assistance is terminated")($s);
		LineAdder("Family very involved in this uprising against ruling class")($s);
		RandomTrait()($s);
	}],
	"m1" => [ "Find unusual object while foraging in trash heap", Invoker("863") ],
	"0" => TableInvoker("215", DiceRoller::from("d20")),
	"1" => [ "Involved by friends in illegal activities", Combiner(DarksideTrait(), Invoker("534")) ],
	"2" => [ "Tragedy occurs", Combiner(RandomTrait(), Invoker("528")) ],
	"3" => [ "Something wonderful occurs", Combiner(LightsideTrait(), Invoker("529")) ],
	"4" => [ "Learn unusual skill", Combiner(NeutralTrait(), Invoker("876")) ],
	"5" => [ "Learn head of household occupation (or patron, or random from culture)", NeutralTrait() ],
	"6" => [ "Runs away from home", Combiner(RandomTrait(), Invoker("215A")) ],
	"7" => [ "Gain religious experience", Combiner(RandomTrait(), Invoker("541")) ],
	"8" => [ "Family has following attitude:", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => [ "Loved by parents or guardians", LightsideTrait() ],
		"2" => [ "Character is unloved", DarksideTrait() ],
		"3" => [ "Family has great plans for character's future and expect fullfillment", RandomTrait() ],
		"4" => [ "Family disapproves character's friends", RandomTrait() ],
		"5" => [ "Family encourages character's interests", LightsideTrait() ],
		"6" => [ (Roll("d2") === 1 ? 'Mother' : 'Father')." is distant and cold towards character", DarksideTrait() ],
	])],
	"9" => [ "Character serves a patron", Combiner(NeutralTrait(), Invoker("543")) ],
	"10-11" => [ "Age-specific event", Invoker("216") ],
	"12" => [ "Gain friend", Combiner(LightsideTrait(), Invoker("750")) ],
	"13" => [ "Race-specific event", Combiner(NeutralTrait(), Invoker("530-533")) ],
	"14" => Repeater(Roll("d3"), Invoker("215")),
	"15" => [ "Exotic event occurs", Combiner(RandomTrait(), Invoker("544")) ],
	"16" => [ "Change/upheaval occurs in family", Combiner(RandomTrait(), Invoker("215B")) ],
	"17" => [ "Something bad happens to character", Combiner(DarksideTrait(), SubtableInvoker(DiceRoller::from("d4"), [
		"1" => [ "Sexually molested by adult", Invoker("750") ],
		"2" => [ "Tragedy occurs", Invoker("528") ],
		"3" => [ "Character teases/angers old woman (witch), has curse put on him", Invoker("868") ],
		"4" => [ "Character acquires rival", Invoker("762") ],
	]))],
	"18" => [ "Something good happens to character", Combiner(LightsideTrait(), SubtableInvoker(DiceRoller::from("d4"), [
		"1" => "Character inherits large sum of money (10x starting money)",
		"2" => [ "Blessed by fairly as reward for good dead", Invoker("869") ],
		"3" => [ "Something wonderful occurs", Invoker("529") ],
		"4" => [ "Character acquires companion", Invoker("761") ],
	]))],
	"19" => [ "Age-specific event", Invoker("216") ],
	"20" => [ "Character develops jaded tastes for exotic (possibly expensive) pleasures", DarksideTrait() ],
	"21" => TableInvoker("215", DiceRoller::from("d20-1")),
	"22" => [ "Rivals force family to move to new locale, or face reprisals", NeutralTrait() ],
	"23" => [ "Something wonderful occurs", Combiner(LightsideTrait(), Invoker("529")) ],
	"24" => [ "Tragedy occurs", Combiner(DarksideTrait(), Invoker("528")) ],
	"25" => function(State $s) {
		$ac = $s->getActiveCharacter();
		$sol = $ac->getModifier('SolMod');
		$ti = $ac->getModifier('TiMod');
		if($ti > 0) $sol -= 5;
		$s->invokeTable("215", new DiceRoller("d20+SolMod+".($sol >= 4 ? "5" : "2")));
	},
	"26" => [ "Character is bethrothed in a political marriage upon reaching majority", DarksideTrait() ],
	"27" => [ "Head of household made close advisor to local ruler", RandomTrait() ],
	"28" => [ "Family travels widely, visiting several countries", NeutralTrait() ],
	"29" => [ "Special tutor teaches character an unusual skill (rank 3)", Invoker("876") ],
	"30" => [ "Family throws extravagant birthday party for character", Combiner(
		LineAdder("And character recieves unusual gift from unknown person"),
		RandomTrait(),
		Invoker("863")
	)],
	"31" => [ "Character exhibits symptoms of exotic personality", Invoker("649") ],
	"32" => [ "Family gives character ".Roll("d10")." slave(s) to do with as he sees fit", RandomTrait() ],
	"33-" => [ "Family gives character personal estate with ".Roll("d10")." sq mi property", NeutralTrait() ],
]);
