<?php

namespace HeroesOfLegend;

return new NamedTable("533", "Monster Event", new DiceRoller("d10"), [
	"1" => [ "Character's home attacked by adventurers", function(State $s) {
		$rel = Roll("d6");
		$hei = Roll("d3+1");
		LineAdder("Adventurers kill ".$rel." family member(s) and steal ".$hei." family heirloom(s)")($s);
		Repeater($rel, Invoker("753"))($s); /* XXX will roll up nonsensical results or duplicates */
		Repeater($hei, Invoker("863"))($s);
	}],
	"2" => "Character driven out by his kind for being 'different'",
	"3" => [ "Character participates in several raids against humankind", Combiner(
	         LineAdder("Character slays ".Roll("d3")." opponent(s)"),
	         LineAdder("And gains rank 4 proficiency in culture-appropriate weapon")
	)],
	"4" => "Character has unmonsterlike craving for fresh vegetables (not elves!)",
	"5" => [ "Character is natural master in an occupation (rank 6 proficiency)", Combiner(
		LineAdder("And lives peacefully in humankind to practice his/her profession"),
		Invoker("422A")
	)],
	"6" => [ "Character befriends human", Invoker("750") ],
	"7" => "Character learns to speak some common language, rank 4 proficiency",
	"8" => "Character learns to read and write some common language, rank 3 proficiency",
	"9" => [ "Character knows of great treasure owned by rival monsters of same species",
	         LineAdder("Character must determine whether or not to betray his/her own kind for reward") ],
	"10" => "Character has natural ability to pass as benign humanoid (or disguise monstrous aspects of appearance)",
]);
