<?php

namespace HeroesOfLegend;

/* XXX noncombat duties add 5 */
return new NamedTable("535B", "Military Event", DiceRoller::from("d20"), [
	"-6" => [ "Character is involved in major battle", function(State $s) {
		$s->invoke("535C");
	}],
	"7-8" => [ "Character reenlists in same branch for another 5 years", Combiner(
		function(State $s) {
			if(Roll("d6") === 6) $s->getActiveCharacter()->promote($s);
		},
		Repeater(Roll("d4"), Invoker("535B"))
	)],
	"9" => [ "Character's prowess and intelligence gets him/her reassigned in special forces", Invoker("537") ],
	"10" => [ "Character is transferred to a noncombat unit", Invoker("536") ],
	"11" => [ "Character is made an officer/promoted", function(State $s) {
		$s->getActiveCharacter()->promote($s);
	}],
	"12" => [ "Character's unit is involved in various skirmishes", function(State $s) {
		if(Roll("d10") >= 8) {
			$s->invokeTable("535C", new DiceRoller("d20"));
		}
	}],
	"13" => [ "Character's unit ambushed by superior force", TableInvoker("535C", new DiceRoller("d20+ViMod-d4-d20")) ],
	"14" => function(State $s) {
		$ac = $s->getActiveCharacter();
		$pv = min(3, $ac->getModifier('ViMod'));
		$s->invoke("535C");
		
		if($ac->getModifier('ViMod') > $pv) {
			LineAdder("And character's side wins")($s);
			LineAdder("Commanding general becomes new ruler of land")($s);
		} else {
			LineAdder("And character's side loses")($s);
			LineAdder("All troops in unit are made outlaws, captured traitors get punished")($s);
			SubentryCreator(
				"875", "Crime", null,
				TableInvoker("875A", new TrivialRoller(9)),
				Invoker("875B")
			)($s);
		}
		
		return "Character's unit is involved in plot to overthrow government and control land";
	},
	"15" => [ "Character's prowess and intelligence gets him/her reassigned in special forces", Invoker("537") ],
	"16" => [ "Army ravaged by disease", function(State $s) {
		if(Roll("d6") === 6) {
			LineAdder("And character becomes allergic to cold/damp")($s);
			$s->invokeTable("649D", new TrivialRoller(11));
		}
	}],
	"17" => [ "Character reenlists for 5 years in a different service", Combiner(
		Invoker("535A"),
		Repeater(Roll("d4"), Invoker("535B"))
	)],
	"18" => "Character learns new weapon skill (of choice)",
	"19" => function(State $s) {
		/* XXX This one is crazy, nerf it? */
		$y = Roll("d4");
		Repeater(2*$y, TableInvoker("535B", new TrivialRoller(-5), true))($s);
		return "Character's hitch extended by ".$y." year(s) as major war breaks out";
	},
	"20-21" => [ "Fierce war breaks out, situation is grim", function(State $s) {
		LineAdder("All noncombat troops are put in the field as light infantry")($s);
		SubtableInvoker(DiceRoller::from("d10"), [
			"1-3" => "Enemy: armies from neighboring land",
			"4" => "Enemy: armies of monsters",
			"5-6" => "Enemy: civil war",
			"7" => "Enemy: peasant rebellion",
			"8" => "Enemy: war of succession (to determine new ruler)",
			"9" => "Enemy: holy war against enemies of main religion",
			"10" => "Enemy: monsters from another plane (aliens, demons, etc.)",
		])($s);
		LineAdder("Character is in the thickest of battle, ".($b = Roll("d4+1"))." battles occur")($s);
		Repeater($b, Invoker("535C"))($s);
	}],
	"22-23" => "Character increases one occupation skill by one rank (of choice)",
	"24" => [ "Character's unit is assigned to accompany military unit in the field", Invoker("535B") ],
	"25" => [ "Event with leader of unit", Invoker("543C") ],
]);
