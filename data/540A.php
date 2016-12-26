<?php

namespace HeroesOfLegend;

$free = function(State $s) {
	$s->getActiveCharacter()->setImprisoned(false);
};

return new NamedTable("540A", "Prison Event", DiceRoller::from("d10"), [
	"1" => [ "Character escapes (after serving ".Roll("d100")."% of sentence)", Combiner(
		SubtableInvoker(DiceRoller::from("d8"), [
			"1-2" => "A reward of ".Roll("d20*100")." gp is offered",
			"3-4" => Roll("d6")." other prisoner(s) accompanied the character",
			"5" => "Guard helped prisoners in their escape",
			"6" => [ "Character was forced to kill particularly corrupt guard during escape",
			         LineAdder("And if caught, character's life will be forfeit") ],
			"7" => [ "Powerful criminal escaped with character and goes relatively straight, becomes character's patron",
			         Invoker("755", "543B", "543C") ],
			"8" => Repeater(Roll("d3+1"), function(State $s) use(&$anon) { $anon->execute($s); }),
		], 0, $anon), $free)],
	"2" => [ "Ruler of land declares general amnesty, character is freed after serving ".Roll("d10*10")."% of sentence", $free ],
	"3" => [ "Disease ravages prison, character survives and gains fame as tender of the sick",
	         LineAdder("Surviving prisoners and guards treat characters as hero") ],
	"4" => "Character is whipped frequently by guards",
	/* Book type, 4 is listed twice and there's no entry for 7 */
	"5" => [ "Character serves sentence in special type of punishment", SubtableInvoker(DiceRoller::from("d4"), [
		"1" => "Character is a galley slave (+1 Strength)",
		"2" => "Character works in the mines (-1 Constitution)",
		"3" => "Character is placed in a work gang",
		"4" => [ "Character is sold in to slavery for duration of sentence", Combiner($free, Invoker("539")) ],
	])],
	"6-7" => "Character learns thieving skills (+".Roll("d3+1")." ranks)",
	"8" => "Character tries to escape, but is caught (+5 years to sentence)",
	"9" => [ "Character participates in prison uprising", function(State $s) {
		if($leader = (Roll("d6") === 6)) {
			LineAdder("And is the leader of uprising")($s);
		}
		if(Roll("d6") >= 4) {
			LineAdder("And it succeeds and character escapes")($s);
			$s->getActiveCharacter()->setImprisoned(false);

			if($leader) {
				LineAdder("Character gains ".($f = Roll("d6"))." low-ability follower(s)")($s);
				Repeater($f, Invoker("761C"))($s);
			}
		} else {
			LineAdder("But it fails and character gets tortured")($s);
			$s->invoke("870");
		}
	}],
	"10" => [ "Character is tortured and receives serious injury", Invoker("870") ],
]);
