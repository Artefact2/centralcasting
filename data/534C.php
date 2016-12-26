<?php

namespace HeroesOfLegend;

/* Another typo in the book! (534B) */
return new NamedTable("534C", "Underworld Event", DiceRoller::from("d20"), [
	"1" => "Join a gang (members usually same age/sex as character, come up with a gang name)",
	"2" => "Jailed for a few days in a sweep of the streets by law enforcement officials",
	"3" => [ "Seriously wounded in a fight", Invoker("870") ],
	"4" => [ "Character looks like a hardened criminal",
	         LineAdder("And is automatically suspect whenever a crime occurs") ],
	"5" => [ "Character becomes informant for the law", function(State $s) {
		if(Roll("d6") === 6) {
			LineAdder("And character is known as a snitch in the underworld, has a contract on his life")($s);
		}
	}],
	"6" => [ "Participated in a large jewel heirst with ".Roll("d4")." other(s)",
	         LineAdder("But partners vanished with the loot and never reappeared") ],
	"7" => "Key gang boss is hit/slain and character is blamed, members of gang seek character's death",
	"8" => [ "Character is imprisoned for a crime and goes straight", Invoker("875") ], /* XXX 875 doesn't always lead to imprisonment */
	"9" => "Gain ".Roll("d4")." rank(s) in thieving skills (wall climbing, lock picking, hiding, moving silently, disarming traps, etc.)",
	"10" => "Character chooses to go straight and ends life of crime (but is still recognised by criminals)",
	"11" => "Character develops extensive contacts in underworld (thieves, informants, guild officers, thugs, fences, spies etc.)",
	"12" => "Character knows city sewers perfectly",
	"13" => [ "Character learns secret passages/entrances/exits to a local noble's castle/estate", Invoker("758") ],
	"14" => [ "Character discovers several stolen items are cursed and impossible to get rid of",
	          Repeater(Roll("d3"), SubentryCreator("534Z", "Cursed Item", null, Invoker("863", "868"))) ],
	"15" => "Crime lord becomes character's patron, and is grooming him to be a leader of organised crime",
	"16" => [ "Character's friends are being killed off in horrible ways", Combiner(
		LineAdder("And law enforcement isn't doing anything about it as only criminals are being killed"),
		LineAdder("And only character and one other are left")
	)],
	"17" => [ "Character disovers prominent and popular government is head of major crime ring", function(State $s) {
		if(Roll("d6") >= 5) {
			LineAdder("And they think character should be silenced")($s);
		} else {
			LineAdder("And they are unaware of character knowledge")($s);
		}
	}],
	"18" => "Gain 1 rank in thieving skills (wall climbing, lock picking, hiding, moving silently, disarming traps, etc.)",
	"19" => [ "Character steals and hides valuable gem (10x starting money)",
	          LineAdder("But it gets stolen by criminal 'friend'") ],
	"20" => "Character becomes leader of gang (or bandit chief, pirate captain, etc.)",
]);
