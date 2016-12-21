<?php

/*<<< Name: Alignment & Attitude >>>*/

Repeater($s->char->traits['L'], Combiner(
	Invoker($s, "647"),
	Invoker($s, "318D")
))();

Repeater($s->char->traits['D'], Combiner(
	Invoker($s, "648"),
	Invoker($s, "318D")
))();


Repeater($s->char->traits['N'], Combiner(
	Invoker($s, "318B"),
	Invoker($s, "318D")
))();

Repeater($s->char->traits['R'], Invoker($s, "318A"))();
$s->char->traits['R'] = 0;

Invoke($s, "318C");
