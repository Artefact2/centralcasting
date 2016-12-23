<?php

namespace HeroesOfLegend;

return new NamedTable("423B", "Lower Class Occupation", DiceRoller::from("d20"), [
	"1" => "Beggar",
	"2-6" => [ "Farmer", SubtableInvoker(DiceRoller::from("d4"), [
			"1" => "Freeman farmer",
			"2" => "Herder",
			"3" => "Sharecropper (works another's lands)",
			"4" => "Serf (agricultural slave)",
	])],
	"7" => "Tinker (repairs pots, sharpens blades)",
	"8" => "Sailor",
	"9-10" => [ "Laborer", SubtableInvoker(DiceRoller::from("d6"), [
			"1" => "Miner",
			"2" => "Stone cutter",
			"3" => "Wood cutter",
			"4" => "Charcoal burner",
			"5" => "Peat cutter",
			"6" => "Unskilled laborer",
	])],
	"11" => "Launderer",
	"12-14" => "Fisherman",
	"15" => [ "Household servant", SubtableInvoker(DiceRoller::from("d6"), [
			"1" => "Butler",
			"2" => "Cook",
			"3" => "Housekeeper",
			"4" => "Gardener",
			"5" => "Stable hand",
			"6" => "Footman",
	])],
	"16" => [ "Tavern/inn employee", SubtableInvoker(DiceRoller::from("d4"), [
			"1" => "Bartender",
			"2" => "Serving person",
			"3" => "Housekeeper",
			"4" => "Bouncer",
	])],
	"17" => "Street vendor",
	"18" => [ "Soldier", Invoker("535") ],
	"19" => [ "Craftsman", Invoker("424A") ],
	"20" => "Second hand shopkeeper",
]);
