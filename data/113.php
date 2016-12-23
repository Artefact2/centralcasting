<?php

namespace HeroesOfLegend;

$nt = new NamedTable("113", "Unusual Birth Circumstance", DiceRoller::from("d100"), [
	"1-5" => "*Noteworth person near home died when character was born",
	"6-10" => "*Wolves and dogs set up a howling when character was born",
	"11-20" => "*Mother died in childbirth",
	"21-23" => "All glassware in house suddenly shattered",
	"24-25" => "*All milk in area soured at character birth",
	"26-27" => "Father believes child is from another man",
	"28-31" => [ "Character has identical twin", function(State $s) {
		if(Roll("d100") <= 20) {
			LineAdder("But were separated at birth")($s);
		}
		if(Roll("d6") === 6) {
			LineAdder("And personality is drastically different")($s);
		}
	}],
	"32-34" => "*Water froze or boiled by itself",
	"35-37" => "Seasonally unnatural weather occured",
	"38" => "*Unnaturally potent storms raged",
	"39-41" => [ "*Born at exactly midnight", Repeater(Roll("d3"), Invoker("113A")) ],
	"42-44" => [ "*Born at exactly noon", Repeater(Roll("d3"), Invoker("113B")) ],
	"45" => Invoker("113"), /* Another error in the book! :-) */
	"46-48" => [ "*Seer declares character will be afflicted by long forgotten ancient family curse", Invoker("868") ],
	"49-50" => [ "*Goose laid golden egg when character was born", function(State $s) {
		$r = Roll("d10");
		if($r >= 7) LineAdder("And character still has it")($s);
		if($r === 10) LineAdder("And it is magical")($s);
	}],
	"51-53" => "*Sky darkened when character was born (or moon and stars went dark) briefly",
	"54-55" => "*House became infested with venomous snakes the next day",
	"56" => "*All gold in house turned into lead",
	"57" => "*All metal in house turned into precious metals",
	"58-62" => "*Infant character left to die on hillside, discovered and subsequently raised by foster parents",
	"63-64" => [ "*Birth happens immediately after a tragedy", Invoker("528") ],
	"65-69" => [ "*Born with unusual birthmark", Invoker("866") ],
	"70-75" => [ "*Born with curse", Invoker("868") ],
	"76-81" => [ "*Born with blessing", Invoker("869") ],
	"82-85" => "Character has a ".(Roll("d2") === 1 ? 'male' : 'female')." fraternal twin",
	"86" => "Character is one of a set of identical triplets",
	"87-88" => [ "*Old hag (witch) prophesies character's death", Invoker("545") ],
	"89-93" => [ "*Born with unusual physical affliction", Invoker("874") ],
	"94" => [ "Born with phychic powers", Repeater(Roll("d3"), Invoker("873")) ],
	"95-99" => [ "Mysterious stranger bestows a gift on the character at birth", Invoker("863") ],
	"100" => function(State $s) {
		Repeater(2, TableInvoker("113", DiceRoller::from("d100+20")))($s);
	},
	"101-105" => "*Mother was reputed to be a virgin",
	"106-110" => [ "*Character is offspring of a mortal and a demon", function(State $s) {
		LineAdder("Every attribute gets +d3 or -d3, 50/50 chance")($s);
		$s->invoke("874", "868", "648");
	}],
	"111-120" => [ "*Character is offspring of avatar of god and a mortal", function(State $s) {
		LineAdder("+3 to attributes related to inherited god-like qualities")($s);
		$s->invoke("874", "863", "869", "864");
	}],
], RandomTable::REROLL_DUPLICATES);

$nt->addPostExecuteHook(function(State $s) {
	$ch = $s->getActiveCharacter()->getActiveEntry()->getChildren();
	$lc = end($ch);
	$fl = $lc->getLines()[0];
	if($fl[0] === '*') {
		$lc->replaceLine($fl, substr($fl, 1));
		$lc->addLine('And people who know this may treat character differently');
	}
});

return $nt;