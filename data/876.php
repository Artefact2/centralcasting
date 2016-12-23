<?php

namespace HeroesOfLegend;

return new NamedTable("876", "Unusual Skill", DiceRoller::from("d20"), [
	"1" => "Social dancing (formal and informal)",
	"2" => "Professional gambling",
	"3" => "Pick pockets",
	"4" => "Gourmet cooking",
	"5" => "Sexual seduction",
	"6" => "Skiing",
	"7" => "Skating",
	"8" => [ "Artistic ability", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => "Painting",
		"2" => "Drawing",
		"3" => "Sculpting",
		"4" => "Jewelry making",
		"5" => "Architectural design",
		"6" => [ "Several talents (duplicates add more skills):", function(State $s) use(&$anona) {
				Repeater(Roll("d2+1"), function(State $s) use(&$anona) { $anona->execute($s); })($s);
			}],
	], 0, $anona)],
	"9" => [ "Musical ability", SubtableInvoker(DiceRoller::from("d8"), [
		"1" => "Play common musical instrument (of choice)",
		"2" => "Sing",
		"3" => "Song writing",
		"4" => "Musical theatre (acting and singing)",
		"5" => "Making/repairing musical instruments",
		"6" => "Play exotic musical instrument (of choice)",
		"7" => "Play by ear",
		"8" => [ "Several talents (duplicates add more skills):", function(State $s) use(&$anonm) {
				Repeater(Roll("d2+1"), function(State $s) use(&$anonm) { $anonm->execute($s); })($s);
			}],
	], 0, $anonm)],
	"10" => [ "Ability with textiles", SubtableInvoker(DiceRoller::from("d6"), [
		"1" => "Sewing",
		"2" => "Weaving",
		"3" => "Tapestry design",
		"4" => "Embroidery",
		"5" => "Knitting",
		"6" => [ "Several talents (duplicates add more skills):", function(State $s) use(&$anont) {
				Repeater(Roll("d2+1"), function(State $s) use(&$anont) { $anont->execute($s); })($s);
			}],
	], 0, $anont)],
	"11" => "Mountaineering (professional climbing)",
	"12" => "Opposite hand weapon use (with weapon of choice)",
	"13" => "Mathematical skill (mental number manipulation skills)",
	"14" => "Model making (make realistic models of things)",
	"15" => "Inventing (useful and useless contraptions)",
	"16" => [ "Theatrical ability", SubtableInvoker(DiceRoller::from("d10"), [
		"1" => "Acting",
		"2" => "Artistic dancing",
		"3" => "Oration (dynamic public speaking)",
		"4" => "Story telling",
		"5" => [ "Musical ability", TableInvoker("876", new TrivialRoller(9)) ],
		"6" => "Disguise (appear as someone else)",
		"7" => [ "Circus skills", TableInvoker("876", new TrivialRoller(17)) ],
		"8" => "Voice impersonation",
		"9" => "Juggling",
		"10" => [ "Several talents (duplicates add more skills):", function(State $s) use(&$anonth) {
				Repeater(Roll("d2+1"), function(State $s) use(&$anonth) { $anonth->execute($s); })($s);
			}],
	], 0, $anonth)],
	"17" => [ "Circus skill", SubtableInvoker(DiceRoller::from("d8"), [
		"1" => "Aerial acrobatics (includes flying trapeze)",
		"2" => "Tight rope walking",
		"3" => "Animal training (exotic animals)",
		"4" => "Clowning (acting like a clown)",
		"5" => [ "Musical ability", TableInvoker("876", new TrivialRoller(9)) ],
		"6" => "Disguise (appear as someone else)",
		"7" => "Horsemanship (riding and tricks)",
		"8" => [ "Several talents (duplicates add more skills):", function(State $s) use(&$anonc) {
				Repeater(Roll("d2+1"), function(State $s) use(&$anonc) { $anonc->execute($s); })($s);
			}],
	], 0, $anonc)],
	"18" => [ "Miscellaneous skill", SubtableInvoker(DiceRoller::from("d10"), [
		"1" => "Astronomy (star watching)",
		"2" => "Astrology (fortune telling)",
		"3" => "Calligraphy (formal/fancy penmanship)",
		"4" => "Lassoing with a lariat",
		"5" => "Wine tasting",
		"6" => "Sailing small craft (includes pleasure boats)",
		"7" => "Bargaining (with merchants, etc.)",
		"8" => "Negotiation and diplomacy",
		"9" => "Prestidigitation (magic tricks)",
		"10" => "Imitate monster noises",
	])],
	"19" => [ "Dabbler at many skills:", Repeater(Roll("2d3"), TableInvoker("876", DiceRoller::from("d18"))) ],
	"20" => [ "Enthusiast at skill (+".Roll("d2")." rank(s)):", TableInvoker("876", DiceRoller::from("d18")) ],
]);
