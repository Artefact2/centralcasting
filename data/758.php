<?php

namespace HeroesOfLegend;

/* XXX: civilized nobles have d4 hobbies instead of an occupation */

$rawdata = [
	'E' =>   [ 'Emperor',        60,           Roll("d4+3"),              100, Roll("d20*10") ],
	'HK' =>  [ 'High King',      Roll("5d10"), Roll("d6"),                85,  Roll("d20*5")  ],
	'KI' =>  [ 'King',           39,           Roll("d4+1"),              100, Roll("d10*10") ],
	'KA' =>  [ 'Kahn',           Roll("5d8"),  Roll("d6"),                30,  Roll("d10*5")  ],
	'PR' =>  [ 'Prince (Royal)', Roll("d4"),   Roll("d6"),                70,  Roll("d20*5")  ],
	'AD' =>  [ 'Archduke',       Roll("4d10"), Roll("d3+1"),              75,  Roll("d10*5")  ],
	'D' =>   [ 'Duke',           Roll("4d8"),  Roll("d3"),                85,  Roll("d10*5")  ],
	'M' =>   [ 'Marquis',        Roll("3d10"), Roll("d2"),                60,  Roll("d20+12") ],
	'CT' =>  [ 'Chieftain',      Roll("3d6"),  0,                         40,  Roll("2d6+8")  ],
	'V' =>   [ 'Viscount',       Roll("3d8"),  1,                         50,  Roll("d20+10") ],
	'J' =>   [ 'Jarl',           Roll("3d6"),  0,                         70,  Roll("d6+4")   ],
	'SCT' => [ 'Subchieftain',   Roll("2d6"),  0,                         30,  Roll("d8")     ],
	'C' =>   [ 'Count (Earl)',   Roll("3d6"),  (int)(Roll("d100") <= 90), 40,  Roll("d20+4")  ],
	'B' =>   [ 'Baron',          Roll("2d10"), (int)(Roll("d100") <= 75), 60,  Roll("d10+4")  ],
	'BL' =>  [ 'Baronet (Lord)', Roll("2d8"),  (int)(Roll("d100") <= 60), 30,  Roll("d10")    ],
	'PRU' => [ 'Prince (Ruler)', Roll("4d10"), Roll("d3+1"),              75,  Roll("d10*5")  ],
	'PC' =>  [ 'Prince (Child)', Roll("d40"),  0,                         100, Roll("d10*10") ],
	'K' =>   [ 'Knight (Sir)',   Roll("2d6"),  (int)(Roll("d100") <= 35), 60,  Roll("d4")     ],
	'H' =>   [ 'Hetman',         Roll("d6"),   0,                         85,  Roll("d4")     ],
];

$tdata = [];
foreach($rawdata as $k => [ $title, $timod, $titles, $hchance, $holdings ]) {
	$tdata[$k] = [
		$title,
		function(State $s) use($timod, $titles, $hchance, $holdings) {
			$s->getActiveCharacter()->increaseModifier('TiMod', $timod);

			$s->getActiveCharacter()->getActiveEntry()->addLine(
				"Land holdings: ".(Roll("d100") <= min(97, $hchance) ? $holdings." square miles" : "none/lost")
			);

			Repeat($titles, Invoker("871"), $s);
		},
	];
}

$cumod = $s->getActiveCharacter()->getModifier('CuMod');

if($cumod <= -2) {
	return new NamedTable("758A", "Nobles", DiceRoller::from("d100"), [
		"1" => $tdata["HK"],
		"2-30" => $tdata["CT"],
		"31-100" => $tdata["SCT"],
	]);
}

if($cumod <= 0) {
	return new NamedTable("758B", "Nobles", DiceRoller::from("d100"), [
		"1-10" => $tdata["KA"],
		"11-40" => $tdata["CT"],
		"41-80" => $tdata["SCT"],
		"81-100" => $tdata["H"],
	]);
}

if($cumod <= 2) {
	return new NamedTable("758C", "Nobles", DiceRoller::from("d100"), [
		"1-2" => $tdata["HK"],
		"3-15" => $tdata["KI"],
		"16-25" => $tdata["PR"],
		"26-45" => $tdata["CT"],
		"46-60" => $tdata["J"],
		"61-70" => $tdata["SCT"],
		"71-75" => $tdata["B"],
		"76-80" => Roll("d100") <= 21 ? $tdata["PRU"] : $tdata["PC"],
		"81-100" => $tdata["H"],
	]);
}

return new NamedTable("758D", "Nobles", DiceRoller::from("d100"), [
	"1" => $tdata["E"],
	"2-5" => $tdata["K"],
	"6-15" => $tdata["PR"],
	"16-20" => $tdata["AD"],
	"21-25" => $tdata["D"],
	"26-35" => $tdata["M"],
	"36-50" => $tdata["V"],
	"51-60" => $tdata["C"],
	"61-75" => $tdata["B"],
	"76-78" => $tdata["BL"],
	"79-90" => Roll(100) <= 21 ? $tdata["PRU"] : $tdata["PC"],
	"91-100" => $tdata["K"],
]);
