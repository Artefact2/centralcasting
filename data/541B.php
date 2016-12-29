<?php

namespace HeroesOfLegend;

return new NamedTable("541B", "Religious Event", new DiceRoller("d20"), [
	"1" => "Character forms new religion devoted to previously unknown god (claiming divine inspiration)",
	"2" => "Character makes pilgrimage to important but distant shrine of god", /* Another typo (pilgrammage) */
	"3" => "Character has vision of god's primary enemy",
	"4" => "God asks character, in vision, to perform sacred but dangerous mission",
	"5-9" => [ "Character joins god's religion", SubtableInvoker(new DiceRoller("d10"), [
		"1-4" => "Merely a temple-goer, no serious devotion",
		"5-7" => "Devoted follower of god's principles of faith",
		"8-9" => "Fervent belief, seeks to spread god's faith",
		"10" => "All-consuming fanatical passion, entire life focused on god's religion",
	])],
	"10" => function() {
		return Roll("d2") === 1 ? "Character believes self to be a reincarnated hero"
			: "Character believes self to be a reincarnated villain";
	},
	"11" => function() {
		return Roll("d2") === 1 ? "Others believe character to be a reincarnated hero"
			: "Others believe character to be a reincarnated villain";
	},
	"12" => "Followers of god accuse character of crime against their god (if applicable, get excommunicated from religion)",
	"13" => [ "Character makes prophetic statements", function(State $s) {
		if(Roll("d10") >= 6) {
			LineAdder("And is quite unpopular as a consequence")($s);
		}
	}],
	"14" => [ "Character joins holy war sponsored by god's religion", Invoker("535") ],
	"15" => [ "Character inadvertantly desecrates holy shine", SubtableInvoker(new DiceRoller("d6"), [
		"1-2" => "God's followers persecute character",
		"3" => "Followers seek reparations",
		"4" => "Followers shun character",
		"5" => "Most other religions shun character",
		"6" => "Religious assissins seek character's death",
	])],
	"16" => [ "Character uncovers activities of evil cult", SubtableInvoker(new DiceRoller("d6"), [
		"1" => "Cult seeks to have character join them",
		"2" => "Cult seeks to kill character",
		"3-4" => [ "Because of character, forces of good were able to eradicate the branch",
		           LineAdder("And character becomes a hero") ],
		"5" => [ "Because of character, forces of good were able to eradicate the branch",
		         LineAdder("And character becomes a hero, but cult now wants character dead") ],
		"6" => "Others shun character, possibly out of fear for evil cult",
	])],
	"17" => "Enemies of religion persecute character",
	"18" => "Character is taught a religion-appropriate skill by temple priests",
	"19" => "Character studies priesthood for ".Roll("d4")." year(s) (+2 ranks in literacy, +".Roll("d3")." rank(s) in religious knowledge)",
	"20" => [ "Character learns more than ever wished about evil powers and principalities in book in temple", function(State $s) {
		if(Roll("d100") >= 80) {
			LineAdder("And develops exotic personality because of this knowledge")($s);
			$s->invoke("649");
		}
	}],
]);
