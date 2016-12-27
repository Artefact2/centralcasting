<?php

namespace HeroesOfLegend;

return new NamedTable("544", "Exotic Event", DiceRoller::from("d20"), [
	"1" => [ "Some god asks character to become its agent on earth", Combiner(
		LineAdder("Character accepts and receives unusual pet as gift"),
		Invoker("864", "759")
	)],
	"2" => [ "Character befriends intelligent nonhumanoid monster", Invoker("756") ],
	"3" => [ "Character stumbles into magical portal and is transported to his current location (land far away)",
	         CharacterSandboxer(true, $c, Invoker("102")) ], /* XXX "treat character as orphan" */
	"4" => [ "Character's gender changed by powerful magic", Combiner(
		LineAdder("Powerful magic (quest) may remove the change/curse"),
		LineAdder("Or character can accept it and be unwilling to change back"),
		SubtableInvoker(DiceRoller::from("d6"), [
			"1" => "Caused by god's whim",
			"2" => "Caused by evil curse by unknown enemy",
			"3" => "Caused by ancient artifact found by character",
			"4" => "Caused by warped wizard who since disappeared",
			"5" => "Caused by removal of curse made at character's birth",
			"6" => [ "Effect is temporary (brought by stress, fatigue, romantic arousal, etc.)", function(State $s) use(&$gs) {
					$gs->execute($s);
			}],
		], 0, $gs))],
	"5" => "Character discovers ability to use magical spell as natural skill (GM decides)",
	"6" => [ "Character survives deadly encounter with nonhumanoid monster (+2 ranks in combat skills against enemy)",
	         Invoker("756") ],
	"7" => [ "Cross-planar rift opens and character is abducted then reappears shortly after",
	         LineAdder("But character looks ".Roll("d10+10")." years older and has no memory of it") ],
	"8" => [ "Character finds hidden cache of ancient treasure in ruined abandoned place", function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->getModifier('SolMod') < 2) {
			$ac->setModifier('SolMod', 2);
			LineAdder("And becomes Well-to-do")($s);
		} else if($ac->getModifier('SolMod') === 2) {
			$ac->increaseModifier('SolMod', 2);
			LineAdder("And becomes Wealthy")($s);
		}
	}],
	"9" => [ "Followers of unknown god think character must mate with an avatar of their god",
	         LineAdder("Character disagrees and is still harassed by the followers") ],
	"10" => [ "Character is struck by falling star on his birthday, passes through his body",
	          LineAdder("And character feels different as if something awakened from within (GM special 978#544A)") ],
	"11" => [ "Character befriends Extremely Wealthy person", Combiner(Invoker("7101"), SubtableInvoker(DiceRoller::from("d3"), [
		"1" => "Much, much older than character",
		"2" => "About same age as character",
		"3" => "Much younger than character (maybe child)",
	]))],
	"12" => [ "Character finds waterlogged old chest after mighty storm, sealed with rusty chains", Combiner(
		LineAdder("Inside is a limp, bedraggied drowned young animal"),
		LineAdder("Animal looks recently dead but casually wakes up and starts cleaning itself"),
		Invoker("759")
	)],
	"13" => [ "Character is mistaken for missing offspring of ruler, taken to live in ruler's household", function(State $s) {
		if(Roll("d6") === 6) {
			LineAdder("And missing offspring is ruler's heir")($s);
		}
		LineAdder("After ".Roll("d6")." year(s):")($s);
		SubtableInvoker(DiceRoller::from("d6"), [
			"1" => "Ruler assassinated by rivals, character suspected of being killer",
			"2" => "Character made to marry unpleasant, older ruler of another land",
			"3" => "Missing offspring returns; character is seen as imposter and is hunted",
			"4" => [ "Character is revealed as imposter, accused of killing missing offspring", Combiner(
				LineAdder("Character gets thrown in dungeon for life"),
				LineAdder("But after ".Roll("d6")." year(s) offspring returns and character is pardoned")
			)],
			"5" => [ "Missing offspring never really disappeared", Combiner(
			         LineAdder("Offspring was only child and slowly went mad"),
			         LineAdder("Ruler brought character to keep appearance of having a competent heir until another child is born")
			)],
			"6" => [ "Combine results in a logical manner:",
			         Repeater(2, function(State $s) use(&$off) { $off->execute($s, DiceRoller::from("d5")); }) ],
		], 0, $off)($s);
	}],
	"14" => [ "More events happen within a few days of each other and are all related in some mysterious way", function(State $s) {
		$ae = $s->getActiveCharacter()->getActiveEntry();
		assert($ae->getSourceID() === "544");
		
		while(($ae = $ae->getParent()) !== null) {
			if($ae->getSourceID() === "544") continue;
			if(!preg_match('%(^|\s)events?(\s|$)%i', $ae->getSourceName())) continue;
			
			Repeater(Roll("d3+1"), Invoker($ae->getSourceID()))($s);
			return;
		}

		/* Couldn't find events to reroll, just reroll exotic event */
		$s->invoke("544");
		return '';
	}],
	"15" => [ "Evil ruler orders all persons of character's gender, birthplace, and age to be put to death",
	          LineAdder("Character is the only one (as far as he/she knows) to escape this heinous act") ],
	"16" => [ "Character and another PC/notable NPC become acquainted with each other", SubtableInvoker(DiceRoller::from("d10"), [
		"1-3" => "They become fast friends, companions forever",
		"4" => "They become acquainted with each other, but never really develop friendship",
		"5-6" => "They become rivals (if both have same gender, compete for girl/boyfriends), always seek same goals",
		"7-8" => [ "They become romantically involved with each other (reroll if same gender)", function(State $s) {
			if(Roll("d6") >= 5) LineAdder("And romance continues until present time")($s);
		}],
		"9" => function(State $s) use(&$acq) {
			$acq->execute($s, DiceRoller::from("d8"));
			if(Roll("d2") === 1) {
				return "Character saves other's life";
			} else {
				return "Other saves character's life";
			}
		},
		"10" => function(State $s) use(&$acq) {
			$acq->execute($s, DiceRoller::from("d8"));
			return "Both attend same school/training classes together";
		},
	], 0, $acq)],
	"17" => [ "Vicious animal attacks character on moonlit night", Combiner(
		LineAdder("Character finds he is cursed with lycanthropy (GM selects type of beast)"),
		LineAdder("(Under no circumstances should it benefit character to be lycanthrope)")
	)],
	"18" => [ "Character is attacked by thugs in dark alley at night", Combiner(
		LineAdder("But they run away in terror as they see character's guardian ghost"),
		LineAdder("Ghost cannot be seen/heard by friends"),
		CharacterSandboxer(true, $c, Invoker("750", "114"))
	)],
	"19" => [ "Character is killed in terrible accident", Combiner(
		LineAdder("But body returns to life with two resident souls (character and ancient alien being)"),
		LineAdder("Learn another occupation and ".($r = Roll("d3"))." unusual skill(s) (one at rank 7)"),
		Invoker("423A"),
		Repeater($r, Invoker("876"))
	)],
	"20" => [ "Strange woman gives character a sealed box",
	          LineAdder("And tells character to keep it safe before dropping dead (dagger in her back, GM special 978#544B)") ],
]);
