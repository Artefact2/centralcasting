<?php

Table($s, "423B", "Lower Class Occupation", Roll(20), [
	"1" => "Beggar",
	"2-6" => [ "Farmer", function() {
		return "Farmer (".[
			"freeman farmer",
			"herder",
			"sharecropper (works another's lands)",
			"serf (agricultural slave)",
		][Roll(4) - 1].")";
	}],
	"7" => "Tinker (repairs pots, sharpens blades)",
	"8" => "Sailor",
	"9-10" => [ "Laborer", function() {
		return "Laborer (".[
			"miner",
			"stone cutter",
			"wood cutter",
			"charcoal burner",
			"peat cutter",
			"unskilled laborer",
		][Roll(6) - 1].")";
	}],
	"11" => "Launderer",
	"12-14" => "Fisherman",
	"15" => [ "Household servant", function() {
		return "Household servant (".[
			"butler",
			"cook",
			"housekeeper",
			"gardener",
			"stable hand",
			"footman",
		][Roll(6) - 1].")";
	}],
	"16" => [ "Tavern/inn employee", function() {
		return "Tavern/inn employee (".[
			"bartender",
			"serving person",
			"housekeeper",
			"bouncer",
		][Roll(4) - 1].")";
	}],
	"17" => "Street vendor",
	"18" => "Soldier", /* XXX 535 */
	"19" => [ "Craftsman", Invoker($s, "424A") ],
	"20" => "Second hand shopkeeper",
]);

Invoke($s, "426");
