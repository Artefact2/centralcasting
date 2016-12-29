<?php

namespace HeroesOfLegend;

return new NamedTable("546B", "Other Event", new DiceRoller("d20"), [
	"1" => "Nothing unusual occured",
	"2-4" => Repeater(2, Invoker("546B")),
	"5" => [ "Papers found in parent's home reveal secret:", SubtableInvoker(new DiceRoller("d4"), [
		"1" => [ "Parent was once noble living in exile", CharacterSandboxer(true, $c, Invoker("758")) ],
		"2" => "Parent was powerful wizard",
		"3" => "Parent was illegitimate child of former ruler",
		"4" => [ "Parent was not human but a monster who could assume human form", Invoker("753") ],
	])],
	"6" => "When character visits parent's grave, it has been opened and tomb is empty",
	"7" => function(State $s) {
		if($s->getActiveCharacter()->hasMother() || $s->getActiveCharacter()->hasFather()) {
			return "Remaining parent remarries within ".Roll("d4")." year(s)";
		}

		$s->invoke("546B");
		return '';
	},
	"8" => function(State $s) {
		if($s->getActiveCharacter()->hasMother() || $s->getActiveCharacter()->hasFather()) {
			return "Remaining parent remarries immediately";
		}

		$s->invoke("546B");
		return '';
	},
	"9" => "Close friend of parent confides to character, he/she believes the parent was murdered",
	"10" => [ "Surviving parent (or close relative) blames character for parent's death", Invoker("545") ],
	"11" => [ "Inheritance has already been claimed by another relative", Invoker("753") ],
	"12" => "Parent's ghost appears to character and demands that injustice be righted",
	"13" => "Journal found in parent's belongings hints at location of lost treasure",
	"14" => "Mysterious stranger wants to buy inherited items for much more they could possibly be worth",
	"15" => "Book found in attic is a spell book, contains ".Roll("d20")." spell(s) of various levels of power",
	"16" => "Evil uncle claims the estate for himself",
	"17" => function(State $s) {
		$sib = $s->getActiveCharacter()->getNumBrothers() + $s->getActiveCharacter()->getNumSisters();
		if($sib > 0) {
			return "Siblings fight over parent's personal belongings";
		}

		$s->invoke("546B");
		return '';
	},
	"18" => "Parent was declared legally dead after disappearing years ago, but could still be alive",
	"19" => "Upon dying, parent collapsed into pile of melting snow (simulacrum was substituted for parent some time ago)",
	"20" => [ "Parent has risen again as undead creature:", SubtableInvoker(new DiceRoller("d4"), [
		"1" => "Vampire",
		"2" => "Ghoul",
		"3" => "Ghost",
		"4" => "Barrow wight, wraith or spectre",
	])],
]);
