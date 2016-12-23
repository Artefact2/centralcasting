<?php

namespace HeroesOfLegend;

return new NamedTable("216B", "Special Event of Adolescence", DiceRoller::from("d20"), [
	"1" => "Learn to use a weapon (of choice, rank 3, culture appropriate)",
	"2" => [ "Character gets tatooed with unusual marking", Invoker(866) ],
	"3-4" => [ "Apprenticed to learn an occupation (always at age 13)", Combiner(NeutralTrait(), Invoker("419")) ],
	"5" => "Wizard or priest teaches character a simple spell",
	"6" => [ "Character is accused of crime he did not commit", Invoker("217B") ],
	"7" => [ "Character learns unusual skill", Invoker("876") ],
	"8" => [ "Character acquires hobby", Invoker("427") ],
	"9" => "Learn head of household occupation (".Roll("d3")." rank(s))",
	"10" => [ "Character joins the military", Combiner(
		RandomTrait(),
		SubtableInvoker(DiceRoller::from("d4"), [
			"1" => "Character was drafted during wartime",
			"2" => "Character patriotically volunteered",
			"3" => "Character was rounded up by press gang who needed to meet quota",
			"4" => "Character mistakenly thought he was applying for another job",
		]),
		Invoker("535")
	)], /* XXX C/P from 217 */
	"11" => [ "Participate in rebellion against local authority", Combiner(RandomTrait(), function(State $s) {
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
	})], /* XXX C/P from 217 */
	"12" => [ "Character becomes well-known/famous for event:", Combiner(NeutralTrait(), Invoker("215")) ],
	"13-14" => [ "Character has romantic encounter (ignore children/marriage if <16 or social status too far apart)", Combiner(
		RandomTrait(),
		Invoker("542")
	)],
	"15" => "Character learns another language (of choice, rank 3)",
	"16" => [ "Race-specific event", Combiner(RandomTrait(), Invoker("530-533")) ],
	"17" => [ "Exotic event occurs", Combiner(RandomTrait(), Invoker("544")) ],
	"18" => [ "Tragedy occurs", Combiner(RandomTrait(), Invoker("528")) ],
	"19" => [ "Something wonderful occurs", Combiner(RandomTrait(), Invoker("529")) ],
	"20" => [ "Character is older than usual at beginning of adventuring carreer", Repeater(Roll("d3-1"), Invoker("217")) ],
]);
