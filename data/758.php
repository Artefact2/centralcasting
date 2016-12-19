<?php

/* XXX: civilized nobles have d4 hobbies instead of an occupation */

$rawdata = [
	'E' =>   [ 'Emperor',        60,          Roll(1, 4) + 3,            100, Roll(1, 20) * 10 ],
	'HK' =>  [ 'High King',      Roll(5, 10), Roll(1, 6),                85,  Roll(1, 20) * 5  ],
	'KI' =>  [ 'King',           39,          Roll(1, 4) + 1,            100, Roll(1, 10) * 10 ],
	'KA' =>  [ 'Kahn',           Roll(5, 8),  Roll(1, 6),                30,  Roll(1, 10) * 5  ],
	'PR' =>  [ 'Prince (Royal)', Roll(1, 4),  Roll(1, 6),                70,  Roll(1, 20) * 5  ],
	'AD' =>  [ 'Archduke',       Roll(4, 10), Roll(1, 3) + 1,            75,  Roll(1, 10) * 5  ],
	'D' =>   [ 'Duke',           Roll(4, 8),  Roll(1, 3),                85,  Roll(1, 10) * 5  ],
	'M' =>   [ 'Marquis',        Roll(3, 10), Roll(1, 2),                60,  Roll(1, 20) + 12 ],
	'CT' =>  [ 'Chieftain',      Roll(3, 6),  0,                         40,  Roll(2, 6) + 8   ],
	'V' =>   [ 'Viscount',       Roll(3, 8),  1,                         50,  Roll(1, 20) + 10 ],
	'J' =>   [ 'Jarl',           Roll(3, 6),  0,                         70,  Roll(1, 6) + 4   ],
	'SCT' => [ 'Subchieftain',   Roll(2, 6),  0,                         30,  Roll(1, 8)       ],
	'C' =>   [ 'Count (Earl)',   Roll(3, 6),  (int)(Roll(1, 100) <= 90), 40,  Roll(1, 20) + 4  ],
	'B' =>   [ 'Baron',          Roll(2, 10), (int)(Roll(1, 100) <= 75), 60,  Roll(1, 10) + 4  ],
	'BL' =>  [ 'Baronet (Lord)', Roll(2, 8),  (int)(Roll(1, 100) <= 60), 30,  Roll(1, 10)      ],
	'PRU' => [ 'Prince (Ruler)', Roll(4, 10), Roll(1, 3) + 1,            75,  Roll(1, 10) * 5  ],
	'PC' =>  [ 'Prince (Child)', Roll(1, 40), 0,                         100, Roll(1, 10) * 10 ],
	'K' =>   [ 'Knight (Sir)',   Roll(2, 6),  (int)(Roll(1, 100) <= 35), 60,  Roll(1, 4)       ],
	'H' =>   [ 'Hetman',         Roll(1, 6),  0,                         85,  Roll(1, 4)       ],
];

$tdata = [];
foreach($rawdata as $k => $line) {
	$tdata[$k] = [
		$line[0],
		function() use(&$s, $line) {
			$s->char->TiMod += $line[1];
			$s->char->LandTitles = $line[2];
			$s->char->entries[] = [
				"", "Land Holdings", Roll(1, 100) <= min(97, $line[3]) ? $line[4]." square miles" : "none/lost"
			];
		},
	];
}

if($s->char->CuMod === -3) {
	Table($s, "758A", "Nobles", Roll(1, 100), [
		"1" => $tdata["HK"],
		"2-30" => $tdata["CT"],
		"31-100" => $tdata["SCT"],
	]);
} else if($s->char->CuMod === 0) {
	Table($s, "758A", "Nobles", Roll(1, 100), [
		"1-10" => $tdata["KA"],
		"11-40" => $tdata["CT"],
		"41-80" => $tdata["SCT"],
		"81-100" => $tdata["H"],
	]);
} else if($s->char->CuMod === 2) {
	Table($s, "758A", "Nobles", Roll(1, 100), [
		"1-2" => $tdata["HK"],
		"3-15" => $tdata["KI"],
		"16-25" => $tdata["PR"],
		"26-45" => $tdata["CT"],
		"46-60" => $tdata["J"],
		"61-70" => $tdata["SCT"],
		"71-75" => $tdata["B"],
		"76-80" => Roll(1, 100) <= 21 ? $tdata["PRU"] : $tdata["PC"],
		"81-100" => $tdata["H"],
	]);
} else if($s->char->CuMod >= 4) {
	Table($s, "758A", "Nobles", Roll(1, 100), [
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
		"79-90" => Roll(1, 100) <= 21 ? $tdata["PRU"] : $tdata["PC"],
		"91-100" => $tdata["K"],
	]);
} else {
	assert(false);
}

while($s->char->LandTitles > 0) {
	Invoke($s, "871");
	--$s->char->LandTitles;
}
unset($s->char->LandTitles);
