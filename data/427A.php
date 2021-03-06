<?php

namespace HeroesOfLegend;

return new NamedTable("427A", "Type of Hobby", DiceRoller::from("d20"), [
	"1" => "Collect something (weapons, animals, books, paintings, signatures, etc.)",
	"2" => "Dancing (participating, or spectating)",
	"3" => "Play a musical instrument (brass, wind, stringed, percussion, etc.)",
	"4" => "Read for enjoyment",
	"5" => "Write creatively (poetry, histories, biographies, plays, etc.)",
	"6" => "Act (dramatics)",
	"7" => "Draw, paint or sculpt",
	"8" => "Needlework (crochet, needlepoint, sewing)",
	"9" => "Sing",
	"10" => "Study: ".[
		"history", "religion", "art", "astronomy",
		"astrology", "other cultures", "magic", "weapons",
	][Roll("d8-1")],
	"11" => "Sport and athletics: ".[
		"wrestling (+1 Strength)",
		"running (+1 Constitution)",
		"fencing (can wield rapiers)",
		"team ball sport (+1 Dexterity)",
		"horse racing (can ride horses)",
		"swimming (can swim)",
		"archery (can wield bows)",
		"boxing (can fight with fists)",
	][Roll("d8-1")],
	"12" => "Build detailed models",
	"13" => "Appreciate and critique arts (music, drama, poetry, etc.)",
	"14" => "Hairdressing and cosmetics",
	"15" => "Hunting (for sport)",
	"16" => "Gardening",
	"17" => "Breeding dogs",
	"18" => "Animal husbandry (breeding livestock)",
	"19" => "Fishing (for sport)",
	"20" => "Heraldry (study of coats of arms of nobility)",
]);
