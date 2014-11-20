<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');

$lang = array(
  'en' => array(
    'header' => array(
      'weapon_name'           => "Name",
      'weapon_class'          => "Class",
      'weapon_type'           => "Type",
      'cost'                  => "Cost",
      'health_effective'      => "Health",
      'time'                  => "Time",
      'cost_per_sec'          => "Cost/sec",
      'weapon_decay_per_sec'  => "Weapon decay/sec",
      'damage'                => "Effective Damage",
      'weapon_damage'         => "Weapon damage",
      'damage_per_pec'        => "Dmg/PEC",
      'amp_damage'            => "Amp damage",
      'amp_decay'             => "Amp decay/use",
      'amp_decay_per_sec'     => "Amp decay/sec",
      'amp_burn'              => "Amp burn",
      'weapon_burn'           => "Ammo",
      'weapon_dps'            => "Eff. Dmg/sec",
      'weapon_decay'          => "Weapon decay/use",
      'weapon_markup'         => "Weapon markup",
      'weapon_attacks'        => "Attacks",
      'creature_hp'           => "HP",
      'creature_regen'        => "Regen",
      'profit'                => "Bond Profit",
      'profit_mod'            => "Alt. Profit",
      'bond_min'              => "Min Bond",
      'bond_max'              => "Max Bond",

      'weight'     => "Weight",
      'range'      => "Range",
      'power'      => "Power",
      'maxtt'      => "Max.TT",
      'mintt'      => "Min.TT",
      'uses'       => "Total uses",
      'dmgstb'     => "Stb",
      'dmgcut'     => "Cut",
      'dmgimp'     => "Imp",
      'dmgpen'     => "Pen",
      'dmgshr'     => "Shr",
      'dmgbrn'     => "Brn",
      'dmgcld'     => "Cld",
      'dmgacd'     => "Acd",
      'dmgelc'     => "Elc",
      'sib'        => "SIB",
      'hitprof'    => "Hit profession",
      'hitrec'     => "Rec. hit",
      'hitmax'     => "Max hit",
      'dmgprof'    => "Damage profession",
      'dmgrec'     => "Rec. dmg",
      'dmgmax'     => "Max dmg",
      'source'     => "Source",
      'discovered' => "Discovered",
      'found'      => "Found on",
    ),
    'info' => array(
      'weapon_name'           => "Name of the weapon",
      'weapon_class'          => "Class of the weapon",
      'weapon_type'           => "Type of the weapon",
      'cost'                  => "The total average cost in PED to kill the creature. This includes creature health regeneration, " . 
                                 "the cost of overkilling it, skill based hit and crit rate, markup of amplifier and weapon. It is " . 
                                 "calculated by the number of shots needed to kill it multiplied by the total cost for each shot plus " .
                                 "the cost of the average overkill.",

      'health_effective'      => "The effective health of the creature with health regen in mind",
      'time'                  => "Time to kill the creature",
      'profit'                => "Without counting with multipliers (globals if TT is high enough), this is the average return difference from the calculated cost",
      'profit_mod'            => "Same as the Bond Profit column, with the exception of using the current weapons DPP instead of the specified one",
      'bond_min'              => "Minimum possible loot using the current weapons DPP instead of the configured one",
      'bond_max'              => "Maximum possible loot using the current weapons DPP instead of the configured one",
      'cost_per_sec'          => "Cost in PEC/sec to use the weapon (and amplifier if applied)",
      'weapon_decay_per_sec'  => "How much the weapon decays per second in PEC",
      'damage_per_pec'        => "Effective damage per PEC",
      'damage'                => "Effective damage per shot (including amplifier if applied)",
      'weapon_damage'         => "Weapon damage (without the amplifier if applied)",
      'amp_damage'            => "Amplifier damage",
      'amp_decay'             => "Amplifier decay per use in PECs",
      'amp_decay_per_sec'     => "Amplifier decay per second in PECs",
      'amp_burn'              => "Amplifier ammo burn",
      'weapon_burn'           => "Ammo burn per use",
      'weapon_dps'            => "Effective damage per second",
      'weapon_decay'          => "Weapon decay per use in PEC",
      'weapon_markup'         => "Weapon markup",
      'weapon_attacks'        => "Attacks per minute",
      'creature_hp'           => "Creature health",
      'creature_regen'        => "Creature health regen",

      'weight'     => "Weight of the weapon",
      'range'      => "Range of the weapon",
      'power'      => "Power of the weapon",
      'maxtt'      => "Maximum TT of the weapon",
      'mintt'      => "Minimum usable TT of the weapon",
      'uses'       => "Total uses of the weapon",
      'dmgstb'     => "Damage stab",
      'dmgcut'     => "Damage cut",
      'dmgimp'     => "Damage impale",
      'dmgpen'     => "Damage penetration",
      'dmgshr'     => "Damage shrapnel",
      'dmgbrn'     => "Damage burn",
      'dmgcld'     => "Damage cold",
      'dmgacd'     => "Damage acid",
      'dmgelc'     => "Damage electric",
      'sib'        => "Skill increase bonus",
      'hitprof'    => "Hit profession used",
      'hitrec'     => "Recommended hit profession level to use the weapon",
      'hitmax'     => "Hit profession level needed to max all the hit statistics of the weapon",
      'dmgprof'    => "Damage profession used",
      'dmgrec'     => "Recommended damage profession level to use the weapon",
      'dmgmax'     => "Damage profession level needed to max all the damage statistics of the weapon",
      'source'     => "What the weapon can be obtained from",
      'discovered' => "Which version it was discovered",
      'found'      => "Which planet the weapon was found on",
    ),
    'search' => array(
      'hit_profession'        => "Hit profession",
      'damage_profession'     => "Damage profession",
      'skip-unknown-skill'    => "Skip with unknown skill",
      'skip-unknown-skill-tooltip' => "Will not include weapons with an unkonwn skill requirement if profession levels are entered.",
      'toggle-bond-theory'    => "Toggle bond theory",
      'toggle-bond-theory-tooltip' => "The Bond Theory is the theory of max/min possible loot from any creature based on it's cost " .
                                      "to kill, and the minimum possible global",
      'use-enhancer-decay'    => "Use enhancer decay",
      'use-enhancer-decay-tooltip' => "Experimental. Decay rates vary from slot to slot and type to type. Values are average from testing.",
      'include_weapon_markup' => "Include weapon markup",
      'include_amp_markup'    => "Amp markup",
      'skill_based'           => "Skill based",
      'team_size'             => "Team size",
      'team-size-tooltip'     => "Default is 1. Higher values multiplies the weapon attacks by the team size. Assumes everyone in the team has the same weapon configuration.",
      'maximize'              => "Show all columns",
      'weapon_name'           => "Weapon name",
      'column'                => "Column",
      'select-energy-amp'     => "(Energy amp)",
      'select-blp-amp'        => "(BLP amp)",
      'select-scope'          => "(Scope)",
      'select-sight-1'        => "(Sight)",
      'select-sight-2'        => "(Sight 2)",
      'select-class'          => "(Class)",
      'select-type'           => "(Type)",
      'select-creature'       => "(Creature)",
      'select-heal'           => "(Medical Tool)",
      'select-creature-hp'    => "HP",
      'select-creature-regen' => "Regen",
      'select-weapon-id'      => "Weapon ID",

      'skip-header'           => "Skip list",
      'skip-clear'            => "Clear all",
      'skip-remove'           => "Remove selected",
      
      'enhancer-none'         => "Select enhancer for socket",
      'enhancer-damage'       => "Weapon Damage Enhancer",
      'enhancer-accuracy'     => "Weapon Accuracy Enhancer",
      'enhancer-economy'      => "Weapon Economy Enhancer",
      'enhancer-range'        => "Weapon Range Enhancer",
      'enhancer-skill'        => "Weapon Skill Modification Enhancer",
      
      'enhancer-heal-none'    => "Select enhancer for socket",
      'enhancer-heal-economy' => "Medical Tool Economy Enhancer",
      'enhancer-heal-heal'    => "Medical Tool Heal Enhancer",
      'enhancer-heal-skill'   => "Medical Tool Skill Modification Enhancer",
      
      'change-all-enhancers'  => "Change all enhancers",
      'toggle-enhancers'      => "Select enhancers",
      'change-all-heal-enhancers' => "Change all heal enhancers",
      'toggle-heal-enhancers' => "Select heal enhancers",
      'apply-filters'         => "Search",
      'reset'                 => "Reset",
      'ignore-regen'          => "Ignore regen",
      'ignore-regen-tooltip'  => "Some loot theories suggest that higher regen gives higher returns. " .
                                 "This allows you to ignore a creatures regen and calculate the cost as " .
                                 "if the creature had zero regen rate.",
                                 
      'skip-limited'          => "No limited weapons",
      'find-amplifiers'       => "Find amplifiers",
      
      'find-amplifiers-tooltip' => "Tries to find amplifiers (other than the possibly selected one) " .
      							   "that would lower the cost.",
      							   
      'find-finishers'        => "Find finishers",
      'find-finishers-tooltip' => "Tries to find possible finishers which would lower the cost. Pretty " .
                                  "slow if no filters are used.",

      'find-buffs'            => "Apply weapon buffs",
      'find-buffs-tooltip'    => "Show a box where you can input different 'buffs' for the weapons. Recently " .
                                 "items have given certain of these buffs, for example the Thorifoid Berserker's " .
                                 "Helm gives a reload buff of 5%, which if you have you can input in this box and " .
                                 "see what the impact will be of using it.",
                                  
      'find-creatures'        => "Find creatures",
      'find-creatures-tooltip'=> "Tries to find the most profitable creatures to hunt with the found " .
                                 "weapons. Very slow if no filters are used.",
                                 
      'use-healing'           => "Consider player healing",
      'use-healing-tooltip'   => "Will take into consideration that you will need to heal when your HP " .
                                 "gets low, changing the cost to kill based on the creature threat level. " .
                                 "Highly theoretical, just to give an idea of how much healing would " .
                                 "affect the cost of killing.",

      'buff-reload-speed'     => "Reload speed",
      'buff-reload-speed-tooltip' => "Percentage directly affects the number of 'attacks' for the weapons, meaning the number of attacks made per minute. Currently only the Berserker helmets give this buff.",
      'buff-damage'           => "Damage",
      'buff-damage-tooltip'   => "For testing only! Percentage directy affects the 'weapon damage' for the weapons. Currently no item give this buff.",
      'buff-skill-req'        => "Skill req.",
      'buff-skill-req-tooltip' => "For testing only! Affects the 'max hit' and 'max dmg' of the weapons. Currently no item give this buff.",
      'buff-ammo-burn'        => "Ammo burn",
      'buff-ammo-burn-tooltip' => "For testing only! Affects the amount of ammo used by the weapons. Currently no item give this buff.",
      'buff-floor-values'     => "Floor buffed values instead of rounding?",
      'buff-crit-chance'      => "Crit hit chance",
      'buff-crit-chance-tooltip' => "Critical hit change increase.",
      'buff-crit-damage'      => "Crit hit dmg",
      'buff-crit-damage-tooltip'  => "Critical hit damage increase.",
                                 
      'search-weapon-header'  => "Main weapon filters",
      'search-finisher-header'=> "Finisher weapon filters",
      'search-buff-header'    => "Weapon buffs",
      'search-buff-info'      => "Warning: these directly affects the values. No decay is takes into consideration when using these.",
      'search-heal-header'    => "Healing filters",
      'filter-header'         => "Add filters to narrow down search results",
      'add-filter'            => "Add filter",
      'show-hide-filters'     => "Show/hide filters",
    ),
    'error' => array(
      'no-creature-selected'  => "No creature selected.",
      'no-results'            => "No results found for filter.",
    ),
    'details' => array(
      'details-header'        => "Cost details",
      'lost_damage_in_overkill' => "Average overkill",
      'ped_per_hp'            => "PEC/HP",
      'overkill_cost'         => "Cost of average overkill",
      'overkill_percentage'   => "Percentage overkill",
      'amp_decay'             => "Amp decay",
      'weapon_decay'          => "Weapon decay",
      'weapon_decay_from_markup' => "markup",
      'amp_decay_from_markup' => "markup",
      'ammo_cost'             => "Ammo cost",
      'other-amps'            => "Amplifiers",
      'amp-name'              => "Name",
      'amp-cost'              => "Cost",
      'amp-diff'              => "Difference",

      'cost-chart-header'     => "Visualized cost",
      'cost-ammo'             => "Ammo cost",
      'cost-amp'              => "Amp decay",
      'cost-weapon'           => "Weapon decay",
      'cost-overkill'         => "Overkill cost",
      'cost-enhancers'        => "Enhancer decay cost",

      'enhancer-cost'         => "Enhancer cost",
      'regen-cost'            => "Regen cost",
      'overkill'              => "Overkill",
      'regen'                 => "Regenerated health",
      'original-health'       => "Original health",
      'finisher-header'       => "Finishers",
      'finisher-header-1'     => "Avoiding the last usage with the main weapon loweres the cost by",
      'finisher-header-2'     => "(cost of one use). This will on average leave the creature with",
      'finisher-header-3'     => "Below are the most economic ways to kill the creature with the remaining HP.",
      'finisher-name'         => "Weapon name",
      'finisher-cost'         => "Cost with finisher",
      'finisher-raw'          => "Raw cost",
      'finisher-diff'         => "Difference",
      
      'other-creatures'       => "Creatures",
      'creature-header-1'     => "A list of the most profitable creatures to hunt with this weapon setup. The list is " .
      							 "sorted by 'rank', which is calculated by taking the overkill plus the regen, " .
      							 "and divide that number by the total cost of killing the creature. This will rank " .
      							 "creatures by the relative amount of 'wasted' peds. Keep in mind though, " .
      							 "this is highly theoretical and should not be though of as an absolute truth!",
      
      'creature-name'         => "Creature name",
      'creature-rank'         => "Rank",
      'creature-cost'         => "Cost to kill",
      'creature-regen'        => "Regen %",
      'creature-overkill'     => "Overkill %",
      'creature-threat'       => "Threat",
      'creature-damage'       => "Damage",
      'creature-hitpoints'    => "HP",
      
      'other-creature-name-tooltip' => "The name of the creature",
      'other-creature-rank-tooltip' => "The lower the rank the less waste it is to hunt it",
      'other-creature-cost-tooltip' => "How much it would cost to hunt this creature with this weapon setup",
      'other-creature-overkill-tooltip' => "The percentage of average overkill based on the effective health of the mob",
      'other-creature-regen-tooltip' => "The percentage of hit points regenerated based on the effective health of the mob",
      'other-creature-damage-tooltip' => "The amout of damage the creature does",
      'other-creature-hitpoints-tooltip' => "The amount of health the creature has",
      'other-creature-threat-tooltip' => "Threat level; the more towards red, the more dangerous the mob, the more green, the " .
                                         "easier the mob. So, even though this list may suggest one stupidly hard mob for a " .
                                         "weapon, it's economic to hunt it, but this is calculated without the regard for the " .
                                         "amount of damage the mob does. So if the threat is high, you probably will have to " .
                                         "heal a lot, meaning that it's not that economical after all. So take the thread into " .
                                         "consideration. As you now may see, this is theoretical--not always practical--information. " .
                                         "White means the threat is unkonwn.",

      'finisher-name-tooltip' => "If you click on the name a new tab will open with this as a main weapon on the same mob with the " . 
                                 "remaining HP. There you can see if it's worth putting an amplifier on the finisher or not.",

      'finisher-cost-tooltip' => "If you use this finisher instead of the last use of the main weapon, this will be the average cost instead.",
      'finisher-raw-tooltip'  => "How much it will cost to kill the remaining HP of the creature with this finisher.",
      'finisher-diff-tooltip' => "Total cost difference if using this finisher instead of the last use of the main weapon.",

      'other-amp-name-tooltip'=> "The name of the amplifier.",
      'other-amp-cost-tooltip'=> "How much the cost would be if this amplifier is used instead of the selected one (if any).",
      'other-amp-diff-tooltip'=> "Total cost difference if using this amplifier instead of the selected one (if any).",

      'amplifier-header-1'    => "Shows a list of amplifiers that will lower the cost. It is not always the amplifier with the " .
                                 "highest Dmg/PEC that will top this list, since the overkill cost is taken into consideration.",
    ),
    'help' => array(
      'help'                  => "Help!",
      'cost-details'          => "Click on a weapon's cost column to show cost details!",
      'skill-details'         => "Enter your hit and damage profession and they will be taken " .
                                 "into account when calculating the effectiveness of the weapons.",
      'creature-details'      => "If you select a creature, the creature health regeneration will " .
                                 "be included in the calculation, and the cost for killing it will be shown.",
      'enhancer-details'      => "Click to expand the enhancer selection list.",
    ),
  ),
);

?>
