<?php

/*<<< Name: Parents & NPCs >>>*/

Invoke($s, "114A");

$count = Roll(3);
while(--$count >= 0) {
	if($s->char->isNPC === false) {
		$s->char->entries[] = [ "", "", Roll(6) <= 4 ? 'To head of household:' : 'To other parent (if applicable):' ];
	}
	Invoke($s, "114B");
}
