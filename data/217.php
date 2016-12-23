<?php

namespace HeroesOfLegend;

return new NamedTable("217", "Significant Event of Adulthood", DiceRoller::from("2d20+SolMod"), [
	"m1" => [ "Free trapped predatory beast while foraging/hunting for food", Combiner(
		LineAdder("And it returns the favor later"),
		LightsideTrait()
	)],
	"0" => [ "Learn new occupation (rank 2) to earn a living", Combiner(NeutralTrait(), Invoker("420-423")) ],
	"1-2" => [ "Something wonderful occurs", Combiner(RandomTrait(), Invoker("529")) ],
	"3-4" => [ "Tragedy occurs", Combiner(RandomTrait(), Invoker("528")) ],
	"5" => [ "Learn unusual skill", Invoker("876") ],
	"6" => [ "Participate in rebellion against local authority", Combiner(RandomTrait(), function(State $s) {
		if(Roll("d10") >= 9) {
			LineAdder("And it succeeded")($s);
		} else {
			LineAdder("And it failed")($s);
			if(Roll("d10") === 10) {
				LineAdder("And character is now an outlaw")($s);
			} else {
				LineAdder("Only few close friends know of the character's participation")($s);
			}
		}
	})], /* XXX C/P from 216B */
	"7" => [ "Character serves a patron", Combiner(NeutralTrait(), Invoker("543")) ],
	"8" => [ "Character has wanderlust and decides to travel for ".Roll("d6")." year(s)", Combiner(
		NeutralTrait(), Invoker("217A")
	)],
	"9-10" => [ "Character has religious experience", Combiner(LightsideTrait(), Invoker("541")) ],
	"11" => [ "Character saves someone else's life, becomes companion", Combiner(
		LightsideTrait(), Invoker("761A"), Invoker("761C"),
		function(State $s) {
			if(Roll("d2") === 1) return;
			LineAdder("And companion has opposite sex")($s);
			if(Roll("d10") >= 6) return;
			LineAdder("And companion is in love with character")($s);
		})],
	"12-13" => [ "Race-specific event", Combiner(RandomTrait(), Invoker("530-533")) ],
	"14" => Repeater(Roll("d3"), Invoker("217")),
	"15" => [ "Exotic event occurs", Combiner(LightsideTrait(), Invoker("544")) ],
	"16" => "Learn use of a weapon (of choice, rank 3, appropriate to culture/societal status)",
	"17" => [ "Something bad happens to character", Combiner(DarksideTrait(), SubtableInvoker(DiceRoller::from("d3"), [
		"1" => [ "Tragedy occurs", Invoker("528") ],
		"2" => [ "Crude/tactless joke angers old woman (witch), curses character", Invoker("868") ],
		"3" => [ "Character acquires rival", Invoker("762") ],
	]))],
	"18" => [ "Something good happens to character", Combiner(LightsideTrait(), SubtableInvoker(DiceRoller::from("d3"), [
		"1" => [ "Old man rescued from brigands blesses character", Invoker("869") ],
		"2" => [ "Something wonderful occurs", Invoker("529") ],
		"3" => [ "Character acquires companion", Invoker("761") ],
	]))],
	"19" => [ "Character becomes well-known/famous for event:", Combiner(LightsideTrait(), Invoker("217")) ],
	"20" => [ "Character develops exotic personality trait", Invoker("649") ],
	"21" => [ "Character inherits property from a relative", Combiner(
		RandomTrait(),
		Invoker("753"), /* Why not? Book doesn't say so, but makes sense */
		Invoker("863C"),
		LineAdder("GM special 978#217")
	)],
	"22" => TableInvoker("217", DiceRoller::from("2d20-".Roll("d3"))),
	"23-24" => [ "Character becomes engaged in illegal activities", Combiner(DarksideTrait(), Invoker("534")) ], /* XXX 534A? */
	"25" => "Learn to use unusual weapon (rank 3, something alien to culture)",
	"26-28" => [ "Character joins the military", Combiner(
		RandomTrait(),
		SubtableInvoker(DiceRoller::from("d4"), [
			"1" => "Character was drafted during wartime",
			"2" => "Character patriotically volunteered",
			"3" => "Character was rounded up by press gang who needed to meet quota",
			"4" => "Character mistakenly thought he was applying for another job",
		]),
		Invoker("535")
	)], /* XXX C/P from 216B */
	"29-32" => [ "Character has romantic encounter", Combiner(RandomTrait(), Invoker("542")) ],
	"33" => [ "Character acquires hobby", Invoker("427") ],
	"34" => [ "Character develops jaded tastes for exotic (possibly expensive) pleasures", DarksideTrait() ],
	"35-36" => [ "Character accused of a crime he did not commit", Combiner(Invoker("875"), Invoker("217B")) ],
	"37-38" => function(State $s) {
		if($s->getActiveCharacter()->getType() === Character::PC) {
			Repeater(Roll("d3"), Invoker("217"))($s);
			return "Age ".Roll("d6")." year(s), more events occur";
		} else {
			$s->invoke("217");
		}
	},
	"39" => "Choose any one personality trait (318B, 647, 648, or 649)",
	"40-41" => [ "Learn occupation (rank 2)", Combiner(NeutralTrait(), Invoker("420-423"), function(State $s) {
		$line = "Or improve main occupation (+".Roll("d3")." ranks";
		if($s->getActiveCharacter()->getType() === Character::PC) {
			$line .= ", up to 6";
		}
		$line .= ")";
		LineAdder($line)($s);
	})],
	"42-44" => TableInvoker("217", DiceRoller::from("2d20+SolMod+5")),
	"45" => [ "Character is made close advisor to local ruler", NeutralTrait() ],
	"46-48" => [ "Character develops exotic personality trait", Invoker("649") ],
	"49-50" => [ "Family sends character a personal servant (butler) as companion", Invoker("761C") ],
	"51-53" => [ "Ruler slightly below character proposes marriage", LineAdder("It is obviously political in nature") ],
	"54-58" => [ "Radical change in political structure", Combiner(
		LineAdder("Character becomes poor and loses all noble benefits"),
		function(State $s) {
			LineAdder(Roll("d6") >= 5 ? 'And character (and family) are outlaws in the land' : null)($s);
			$ac = $s->getActiveCharacter();
			$ac->setModifier('SolMod', -1);
			$ac->setModifier('TiMod', 0);
		}
	)],
]);
