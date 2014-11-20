<?php

class Damage {
    public static function calculateDamage(Search $search, Weapon $weapon, Enhancer $enhancer) {
        $damage = $weapon->getDamage();
        $dmgprof = $search->getDamageProfession();
        $hitprof = $search->getHitProfession();
        $crit = $enhancer->getCrit();
        $skill = $search->getSkillBased();
        $sib = $weapon->getSib();
        $crit_hit_rate_bonus = $weapon->getCritChance();
        $crit_damage_bonus = $weapon->getCritDamage();

        if ($skill == true && floatval($sib) == 0) {
            $damage = Damage::skillBasedDamage($weapon, $damage, $dmgprof, $hitprof, $crit, $crit_hit_rate_bonus, $crit_damage_bonus);
            $weapon->setDamage($damage);
        }
        else if ($skill == true && floatval($sib) == 1) {
            $damage = Damage::skillBasedDamageSib($weapon, $damage, $dmgprof, $hitprof, $crit);

            $weapon->setDamage($damage);
            $weapon->setAttacks(Damage::skillBasedAttacks($weapon, $hitprof, $weapon->getAttacks()));
        }
        else {
            $hit_mod = floatval($hitprof) / 100;
            $crit_hit_mod = sqrt(floatval($hitprof)) / 10;

            $damage_from = (0.25 + 0.25 * (floatval($dmgprof) / 100)) * $damage;
            $damage_to = $damage;

            $damage = Damage::toEffectiveDamage($weapon, $damage_from, $damage_to, $hit_mod, $crit_hit_mod, $damage, $crit, $crit_hit_rate_bonus, $crit_damage_bonus);
            $weapon->setDamage($damage);
        }

        return $weapon;
    }

    /**
     * HIT ABILITY
     *   10% of Hit Profession.
     *
     * CRITICAL HIT ABILITY
     *   The formula is sqrt(hit_ability*10)/10, which is the same as sqrt(hit_prof)/10 since hit_ability is hit_prof/10.
     */
    public static function skillBasedDamage(Weapon $weapon, $dmg_max, $dmg_prof, $hit_prof, $crit_enhancer_bonus, $crit_hit_rate_bonus, $crit_damage_bonus) {
        $damage_from = (0.25 + 0.25 * ($dmg_prof / 100)) * $dmg_max;
        $damage_to = $dmg_max;

        $hit_ability = $hit_prof / 100;
        $crit_hit_ability = sqrt($hit_prof) / 10;

        return Damage::toEffectiveDamage(
            $weapon, $damage_from, $damage_to, $hit_ability, $crit_hit_ability,
            $dmg_max, $crit_enhancer_bonus, $crit_hit_rate_bonus, $crit_damage_bonus);
    }

    public static function skillBasedDamageSib(Weapon $weapon, $max_damage, $damage_profession, $hit_profession, $crit_enhancer_bonus) {
        $damage_recommended = floatval($weapon->getDamageRecommended());
        $hit_recommended = floatval($weapon->getHitRecommended());
        $damage_max = floatval($weapon->getDamageMax());
        $hit_max = floatval($weapon->getHitMax());
        $damage_profession = floatval($damage_profession);
        $hit_profession = floatval($hit_profession);

        if (Damage::isNotYetSib($damage_recommended, $damage_profession)) {
            $damage_from = 0.25 * $max_damage;
            $damage_to = 0.5 * $max_damage;
        }
        else if (Damage::isSibNow($damage_recommended, $damage_profession, $damage_max)) {
            $from_const = 0.4;
            $from_mod = 0.1;
            $to_const = 0.8;
            $to_mod = 0.2;

            if (Damage::isMindforceWeapon($weapon)) {
                $from_const = 0.25;
                $from_mod = 0.25;
                $to_const = 0.5;
                $to_mod = 0.5;
            }

            $profession_quota = Damage::getProfessionQuota($damage_profession, $damage_recommended, $damage_max);
            $damage_from = ($from_const + $from_mod * $profession_quota) * $max_damage;
            $damage_to = ($to_const + $to_mod * $profession_quota) * $max_damage;
        }
        // not anymore
        else {
            $damage_from = 0.5 * $max_damage;
            $damage_to = $max_damage;
        }

        if (Damage::isNotYetSib($hit_recommended, $hit_profession)) {
            $hit_ability = 0;
            $crit_hit_ability = 0;
        }
        else if (Damage::isSibNow($hit_recommended, $hit_profession, $hit_max)) {
            $profession_quota = Damage::getProfessionQuota($hit_profession, $hit_recommended, $hit_max);
            $hit_ability = 0.3 + $profession_quota * 0.7;
            $crit_hit_ability = sqrt($profession_quota);
        }
        // not anymore
        else {
            $hit_ability = 1;
            $crit_hit_ability = 1;
        }

        $crit_hit_rate_bonus = floatval($weapon->getCritChance());
        $crit_damage_bonus = floatval($weapon->getCritDamage());

        return Damage::toEffectiveDamage(
            $weapon, $damage_from, $damage_to, $hit_ability, $crit_hit_ability,
            $max_damage, $crit_enhancer_bonus, $crit_hit_rate_bonus, $crit_damage_bonus);
    }

    public static function skillBasedAttacks(Weapon $weapon, $hit_profession, $max_reload) {
        $hit_recommended = floatval($weapon->getHitRecommended());
        $hit_max = floatval($weapon->getHitMax());
        $hit_profession = floatval($hit_profession);

        if ($hit_recommended == null || $hit_recommended == 0) {
            return $max_reload;
        }

        if (Damage::isNotYetSib($hit_recommended, $hit_profession)) {
            $reload = 0.45 * $max_reload;
        }
        else if (Damage::isSibNow($hit_profession, $hit_recommended, $hit_max)) {
            $profession_quota = Damage::getProfessionQuota($hit_profession, $hit_recommended, $hit_max);
            $reload = 0.8 * $max_reload + $profession_quota * 0.15 * $max_reload;
        }
        else {
            // not anymore
            $profession_quota = Damage::getProfessionQuota($hit_profession, $hit_recommended, $hit_max, Calculator::SIB_RELOAD_NOT_ANYMORE_MOD);
            $reload = ($profession_quota * 0.05 + 0.95) * $max_reload;
        }

        if ($reload > $max_reload) {
            $reload = $max_reload;
        }

        return $reload;
    }

    /**
     * HIT RATE
     *   Hit Rate is Hit Ability + 80. Since Hit Ability here is 0-10, divide by ten and add 0.8 instead of 80 so we get a
     *   percentage between 0.00 and 1.00.
     *
     * CRITICAL HIT RATE
     *   When Hit Profession is 0 the Critical Hit Rate is 1%, when Hit Profession is 100 Critical Hit Rate is 2%. Divide
     *   by 100 to get a nice percentage between 0.00 and 1.00. The formula is "(CHA / 10) + 1".
     *
     * CRITICAL HIT RATE BONUS
     *   crit_hit_rate_bonus is the percentage from search, value between -99 and +99; so divide by 100 to get percentage
     *   value between -0.99 and +0.99.
     *
     * CRITICAL HIT DAMAGE
     *   Critical hit rate times weapon max damage including enhancers and amps; also add any critical hit damage bonus
     *   (divide by 100 to get percentage, +1 to multiply).
     */
    public static function toEffectiveDamage(Weapon $weapon, $damage_from, $damage_to, $hit_ability, $crit_hit_ability, $dmg_max, $crit_enhancer_bonus, $crit_hit_rate_bonus, $crit_damage_bonus) {
        if ($crit_enhancer_bonus > 0) {
            $crit_hit_ability *= ($crit_enhancer_bonus / 100);
        }

        $hit_rate = 0.8 + $hit_ability / 10;
        $crit_hit_rate = ($crit_hit_ability + 1) / 100;

        if ($crit_hit_rate_bonus > 0) {
            $crit_hit_rate_bonus /= 100;
            $crit_hit_rate += $crit_hit_rate_bonus;
        }

        $crit_hit_damage = $dmg_max * $crit_hit_rate;

        if ($crit_damage_bonus > 0) {
            $crit_hit_damage *= $crit_damage_bonus/2/100 + 1;
        }

        $average_damage = ($damage_from + $damage_to) / 2;
        $effective_damage = $average_damage * $hit_rate + $crit_hit_damage;

        if (DEBUG) {
            echo("<pre>\n");
            echo("crit_damage_bonus:   $crit_damage_bonus\n");
            echo("crit_hit_rate_bonus: $crit_hit_rate_bonus\n");
            echo("crit_hit_rate:       $crit_hit_rate\n");
            echo("crit_hit_damage:     $crit_hit_damage\n");
            echo("crit_enhancer_bonus:     $crit_enhancer_bonus\n");
            echo("dmg_max: $dmg_max\n");
            echo("crit_hit_ability: $crit_hit_ability\n");
            echo("effective_damage: $effective_damage\n");
            echo("effective_damage = $average_damage * $hit_rate + $crit_hit_damage;\n");
            echo("</pre>");
        }

        $weapon->setCriticalHitDamage($crit_hit_damage);
        $weapon->setCriticalHitDamageBonus($crit_damage_bonus);
        $weapon->setCriticalHitRate($crit_hit_rate);
        $weapon->setCriticalHitRateBonus($crit_hit_rate_bonus);
        $weapon->setCriticalHitEnhancerBonus($crit_enhancer_bonus);
        $weapon->setDamageFrom($damage_from);
        $weapon->setDamageTo($damage_to);
        $weapon->setMaximumDamage($dmg_max);
        $weapon->setEffectiveDamage($effective_damage);

        return $effective_damage;
    }

    public static function getProfessionQuota($profession_level, $profession_recommended, $profession_max, $divider_mod = 1) {
        $profession_diff = $profession_level - $profession_recommended;
        $max_diff = $profession_max - $profession_recommended;
        return $profession_diff / ($max_diff * $divider_mod);
    }

    public static function isNotYetSib($profession_recommended, $profession_level) {
        return $profession_recommended > $profession_level;
    }

    // TODO: VU 14.3: "Learning period Skill Increase Bonus (SIB) has been extended for several levels after mastering an item."
    public static function isSibNow($profession_recommended, $profession_level, $profession_max) {
        if ($profession_level < $profession_recommended) {
            return false;
        }
        if ($profession_level > $profession_max) {
            return false;
        }
        return true;
    }

    public static function isMindforceWeapon(Weapon $weapon) {
        return $weapon->getClass() == "Mindforce";
    }
}
