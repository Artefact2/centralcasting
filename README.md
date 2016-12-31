Generate random character (PCs or NPCs) backgrounds using the "Central
Casting: Heroes of Legend" book.

<p align='center'><img src='logo.png' alt='' /></p>

This program doesn't replace the book! It just does most of the work
for you. It's up to you to read in detail what each of the results
mean, in terms of roleplaying.

Dependencies
============

PHP 7.1.

Usage / Exemples
================

Generate a PC:

~~~
./cast pc

Player Character                         (CuMod: +2, SolMod: -3, LegitMod: +0, BiMod: -5, TiMod: +0)
====================================================================================================
+ Birth Events:                                                                              (100  )
|   Character Race: Dwarf                                                                    (101  )
|   Cultural Background: Barbarian                                                           (102  )
|   Social Status: Destitute                                                                 (103  )
|   Birth Legitimacy: Legitimate                                                             (104  )
|   Family: Mother and Father only                                                           (106  )
|   + Siblings: 1 brother(s) and 2 sister(s)                                                 (107  )
|   |   Birth Order: Middle child                                                            (108  )
|   Time of Birth: July the 13th at 11 pm                                                    (109  )
|   Place of Birth: In character's family home                                               (110  )
|   + Parents & NPCs:                                                                        (114  )
|   |   + Occupation: Head of household has one occupation                                   (114A )
|   |   |   Barbarian Occupation: Fisherman                                                  (422A )
|   |   |   + Occupation Performance:                                                        (426  )
|   |   |   |   Work Attitude: Inspired Loyalty                                              (426A )
|   |   |   |   Achievement Level (NPCs Only): Journeyman                                    (426B )
|   |   + To: head of household (usually Father)                                             (114Z )
|   |   |   + Noteworthy Item: NPC is very religious/evangelizing, seeks to convert others   (114B )
|   |   |   |   Deity: Luck goddess                                                          (864  )
|   |   + To: other parent (usually Mother)                                                  (114Z )
|   |   |   Noteworthy Item: NPC is creative, inventive, possibly artistic                   (114B )
|   |   + To: other parent (usually Mother)                                                  (114Z )
|   |   |   + Noteworthy Item: NPC is noted for his personality                              (114B )
|   |   |   |   Lightside Trait: Courageous (brave in the face of adversity)                 (647  )
+ Childhood Event(s), age 12 (human equivalent):                                             (200  )
|   Significant Event of Childhood & Adolescence: Family has following attitude:             (215  )
|                                                 Character is unloved                              
+ Adolescent Event(s), age 13 (human equivalent):                                            (200  )
|   + Significant Event of Childhood & Adolescence: Gain friend                              (215  )
|   |   + Other: Several others together                                                     (750  )
|   |   |   Other: Common soldier                                                            (750  )
+ Adulthood Event(s):                                                                        (200  )
|   + Significant Event of Adulthood: Character becomes well-known/famous for event:         (217  )
|   |   Significant Event of Adulthood: Learn use of a weapon (of choice, rank 3, appropriate(217  )
|   |                                   > to culture/societal status)                               
+ Alignment & Attitude:                                                                      (318  )
|   Lightside Trait: Pious (reverently devoted to worship of a god)                          (647  )
|   Trait Strength (Optional): Driving                                                       (318D )
|   Lightside Trait: Cheerful (always happy and smiling)                                     (647  )
|   Trait Strength (Optional): Average                                                       (318D )
|   Darkside Trait: Self-doubting (unsure of self and abilities)                             (648  )
|   Trait Strength (Optional): Weak                                                          (318D )
|   Alignment: Neutral                                                                       (318C )
Done!: Now what?                                                                             (300  )
       Reread 'Motivations' (page 8)
       Reread 'Linking Events' (page 11)
       Write up your character history (page 12)
~~~

Generate a NPC:

~~~
./cast npc

Non Player Character          (CuMod: +7, SolMod: +0, LegitMod: +0, BiMod: +0, TiMod: +0, ViMod: +0)
====================================================================================================
Gender: Female                                                                               (7101 )
Character Race: Human                                                                        (101  )
Cultural Background: Civilized-Decadent                                                      (102  )
Social Status: Comfortable                                                                   (103  )
Noteworthy Item: NPC has special relationship with family:                                   (114B )
                 Is unfaithful to spouse                                                            
+ Alignment & Attitude:                                                                      (318  )
|   Darkside Trait: Harsh (ungentle, sharp tongue)                                           (648  )
|   Trait Strength (Optional): Strong                                                        (318D )
|   Darkside Trait: Disrespectful (does not show respect)                                    (648  )
|   Trait Strength (Optional): Trivial                                                       (318D )
|   Alignment: Darksided                                                                     (318C )
Done!: Now what?                                                                             (300  )
       Give the NPC a name                                                                          
       Decide whether the NPC is famous, well known, unknown or mysterious                          
       Select NPC's age (page 4)   
~~~

To Do
=====

* ~~Finish all the tables!~~
* Explain how to extend tables and how to write scripts
* ~~Write scripts for NPCs, evil guys, good guys, etc.~~ (Still improvable)
* ~~Fuzz testing~~
* ~~A tree-like structure for table results (better for nested things)~~
* ~~Keep a lot more state (children, parents, etc.) to avoid nonsensical results~~ (Still improvable)
* ~~Proper encapsulation! Code is a mess right now~~ (Still improvable)
* ~~Generate a huge directed graph of all table connections~~
* (Maybe) Web interface / HTML formatter
* (Maybe) Make a pre-filled character sheet
