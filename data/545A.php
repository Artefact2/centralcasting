<?php

namespace HeroesOfLegend;

$reroll = function(State $s) {
	$s->invokeTable("545A", DiceRoller::from("d16"));
};

return new NamedTable("545A", "Cause of Death", DiceRoller::from("d20"), [
	"1" => [ "Victim died accidentally (ladder fall, run over by cart, horse fall, etc.)", function(State $s) {
		/* Actual percentage chance is left as an exercise to the
		 * reader. (Maxima: sum(1/12*i/20, i, 1, 12);) */
		if(Roll("d12") >= Roll("d20")) {
			LineAdder("But everybody who knew the victim blames character for death")($s);
		}
	}],
	"2" => "Premeditated, violent murder (figure out situation, method, motive)",
	"3" => "Killed in a fit of blind passion", /* XXX what does this mean? */
	"4" => "Assassination (professionals were hired, figure out motive)",
	"5" => "Victim died while dueling (figure out reason of duel)",
	"6" => [ "Victim was poisoned (not necessarily murder)", function(State $s) {
		if(Roll("d10") >= 5) {
			LineAdder("And it occured accidentally")($s);
			
			if(Roll("d12") >= Roll("d20")) {
				LineAdder("But everybody who knew the victim blames character for death")($s);
			}
		}
	}],
	"7" => [ "Victim was killed during commission of a crime", function(State $s) {
		if(Roll("d10") < 5) {
			LineAdder("Victim was committing a crime when killed")($s);
		} else {
			LineAdder("Someone killed victim while commiting a crime")($s);
		}
		$s->invoke("875A");
	}],
	"8" => "Victim was killed in self-defense",
	"9" => "Victim was driven to suicide by someone's actions",
	"10" => [ "Victim was driven insane by someone's actions",
	          LineAdder("And died of disease and maltreatment while in the madhouse") ],
	"11" => [ "Victim died of starvation", function(State $s) {
		if(Roll("d6") <= 2) {
			LineAdder("Due to circumstances initiated by someone (caused crops to fail, etc.)")($s);
		} else {
			LineAdder("Because someone deliberately withheld food from victim")($s);
		}
	}],
	"12" => [ "Deceased sacrificed his/her life", SubtableInvoker(DiceRoller::from("d6"), [
		"1-3" => "To save character from death",
		"4-5" => "To save a relative whose life was endangered by someone's actions",
		"6" => [ "To save someone else whose life was endangered by someone's actions", Invoker("750") ],
	])],
	"13" => [ "Victim was imprisoned because of someone's actions and died there", SubtableInvoker(DiceRoller::from("d6"), [
		"1-3" => "Victim commited a crime against someone and was justly imprisoned",
		"4-5" => "Victim was unjustly imprisoned",
		"6" => "Victim was imprisoned in someone else's place",
	])],
	"14" => "Victim tortured to death by someone",
	"15" => "Victim sold into slavery (by someone or his actions) and died while enslaved",
	"16" => [ "Victim died of a disease caught from someone", function(State $s) {
		if(Roll("d6") === 6) {
			LineAdder("And contagious person is stigmatised as plague bearer")($s);
	}
	}],
	
	"17" => [ "Several friends of victim actively seek death of killer (+".Roll("d4+1")." deadly/obsessive rivals)", $reroll ],
	"18" => [ "Victim's spirit cannot rest and haunts killer", Combiner(
		LineAdder("(Some form of attunement may remove the ghost, DM decides)"),
		$reroll
	)],
	"19" => [ "Person thought responsible of death is hated and reviled by all who hear of it", $reroll ],
	"20" => [ "Upon death, victim curses person thought to be responsible of death", Combiner(
		Invoker("868"),
		$reroll
	)],
]);
