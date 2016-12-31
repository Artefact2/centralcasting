<?php

namespace HeroesOfLegend;

return new NamedTable("542A", "Romantic Event", DiceRoller::from("d20"), [
	"1" => "Character's love is unequited (not reciprocal)",
	"2" => "Beloved is already married to another",
	"3-6" => "Character marries his/her beloved",
	"7" => "Character marries the beloved, but they divorce after ".Roll("d6")." year(s)",
	"8" => [ "Both families disapprove of love interest", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => "Character's family has the beloved killed (E)",
		"2" => "Character's family forbids seeing the beloved",
		"3" => "Beloved's family forbids seeing the character",
		"4" => "Beloved's family forces beloved to enter a covent/monastery of celibate religion",
		"5" => [ "Character's family forces him/her to enter covent/monastery of celibate religion", Invoker("541") ],
		"6" => Repeater(2, function(State $s) use(&$disap) { $disap->execute($s); }),
	], 0, $disap)],
	"9" => [ "Beloved is unfaithful", function(State $s) {
		if(Roll("d6") <= 2) {
			LineAdder("But character and beloved reunite and work out their differences")($s);
		} else {
			LineAdder("And romance ends painfully (E)")($s);
		}
	}],
	"10" => [ "Tragedy afflicts the beloved", Invoker("528") ],
	"11" => [ "Beloved has a different social status", function(State $s) {
		$ac = $s->getActiveCharacter();
		
		do {
			CharacterSandboxer(false, $beloved, Invoker("103"))($s);
		} while($beloved->getModifier('SolMod') === $ac->getModifier('SolMod'));

		foreach($beloved->getRootEntry()->getChildren() as $c) {
			$ac->getActiveEntry()->appendChild($c);
		}
	}],
	"12" => [ "Beloved has a different culture", function(State $s) {
		$ac = $s->getActiveCharacter();
		
		do {
			CharacterSandboxer(false, $beloved, Invoker("102"))($s);
		} while($beloved->getModifier('CuMod') === $ac->getModifier('CuMod'));

		foreach($beloved->getRootEntry()->getChildren() as $c) {
			$ac->getActiveEntry()->appendChild($c);
		}
	}],
	"13" => "Beloved is sold into slavery (E)",
	"14" => [ "Beloved has noteworthy appearance", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => "Beloved is particularly unattractive, even ugly",
		"2" => "Beloved is exceptionally attractive",
		"3" => [ "Beloved has unusually colored hair", Invoker("865") ],
		"4" => [ "Beloved has birthmark", Invoker("866") ],
		"5" => "Beloved dresses in odd/exotic manner, stands out in a crowd",
		"6" => Repeater(2, function(State $s) use(&$appearance) { $appearance->execute($s); }),
	], 0, $appearance)],
	"15" => [ "Character causes death of beloved (E)", Invoker("545") ],
	"16" => "Beloved inspires character to greater accomplishement (+1 rank in skill of choice)",
	"17" => function(State $s) {
		$nch = Roll("d4");
		for($i = 1; $i <= $nch; ++$i) {
			SubentryCreator("542Z", "Child #".$i, null, CharacterSandboxer(
				true, $child, Invoker("112")
			))($s);
		}
		return "Character and beloved have ".$nch." child(ren)";
	},
	"18" => "Beloved is much ".[ "older", "younger" ][Roll("d2-1")]." than character",
	"19" => [ "Beloved is of a different race", Invoker("751") ],
	"20" => [ "Character and beloved end romance and go their separate ways, but remain good friends (E)", function(State $s) {
		if(Roll("d10") === 10) {
			LineAdder("And former beloved becomes character's companion")($s);
			$s->invoke("761");
		}
	}],
]);
