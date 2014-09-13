<?php

class Merger {
    public static function addDetails($result, Creature $creature = null, Weapon $weapon, Amplifier $amp, $final) {
        return array_merge($result, array(
            'details' => array(
                'lost_damage_in_overkill' => $final['lost_damage_in_overkill'],
                'ped_per_hp' => $final['ped_per_hp'],
                'weapon_decay_per_second' => $final['weapon_decay_per_sec'],
                'ammo_cost_per_second' => $final['ammo_cost_per_sec'],
                'weapon_burn' => $weapon->getBurn(),
                'amp_burn' => $amp->getBurn(),
                'weapon_attacks' => $weapon->getAttacks(),
                'weapon_markup' => $weapon->getMarkup(),
                'health_effective' => toNumber($final['health_effective']),
                'critical_hit_damage' => $weapon->getCriticalHitDamage(),
                'critical_hit_damage_bonus' => $weapon->getCriticalHitDamageBonus(),
                'critical_hit_rate' => $weapon->getCriticalHitRate(),
                'critical_hit_rate_bonus' => $weapon->getCriticalHitRateBonus(),
                'critical_hit_enhancer_bonus' => $weapon->getCriticalHitEnhancerBonus(),
                'effective_damage' => $weapon->getEffectiveDamage(),
                'damage_from' => $weapon->getDamageFrom(),
                'damage_to' => $weapon->getDamageTo(),
                'max_damage' => $weapon->getMaximumDamage(),

                'overkill_cost' => $final['overkill_cost'],
                'enhancer_cost' => @$final['enhancer_cost'],
                'enhancer_cost_from_markup' => @$final['enhancer_cost_from_markup'],
                'ammo_cost' => $final['_ammo_cost'],
                'amp_decay' => $final['_amp_decay'],
                'amp_markup' => $amp->getMarkup(),
                //'weapon_decay' => $weapon->getDecay(), // TODO: which one?
                'weapon_decay' => $final['_weapon_decay'],
                'weapon_decay_from_markup' => $final['_weapon_decay_from_markup'],
                'amp_decay_from_markup' => $final['_amp_decay_from_markup'],
                'regen_cost' => $final['regen_cost'],

                'creature-id' => $creature == null ? -1 : $creature->getId(),
                'creature-regen' => $creature == null ? -1 : $creature->getRegen(),
                //'amp-laser-fin-id' => $amp_laser_fin_id,
                //'amp-blp-fin-id' => $amp_blp_fin_id,
            )
        ));
    }

    public static function addRestOfColumns($result, Weapon $weapon, $final, $weapon_damage) {
        return array_merge($result, array(
            'health_effective' => toNumber($final['health_effective']),
            'time' => toNumber($final['time']),
            'cost_per_sec' => toNumber($final['cost_per_sec']),
            'damage' => toNumber($weapon->getDamage()),
            #'amp_damage' => toNumber($amp_damage),
            'weapon_damage' => $weapon_damage,
            'range' => roundOneDecimal($weapon->getRange()),
            'weapon_attacks' => floor($weapon->getAttacks()),
            'weapon_dps' => toNumber($final['weapon_dps']),
            'damage_per_pec' => toNumber($final['damage_per_pec']),
            'weapon_decay_per_sec' => toNumber($final['weapon_decay_per_sec']),
            'weapon_decay' => toNumber($weapon->getDecay()),
            'weapon_burn' => floor($weapon->getBurn()),
            'weapon_markup' => toNumber($weapon->getMarkup()),
            #'creature_hp' => toNumber($creature_hp),
            #'creature_regen' => toNumber($creature_regen),
            'hitmax' => $weapon->getHitMax(),
            'dmgmax' => $weapon->getDamageMax(),
        ));
    }

    public static function addAlwaysShownColumns($result, Search $search, Weapon $weapon, $final) {
        return array_merge($result, array(
            'id' => $weapon->getId(),
            'can_calc_skill' => ($search->getWantSkillBased() ? $search->getSkillBased() : true),
            'weapon_name' => $weapon->getName(),
            'weapon_class' => $weapon->getClass(),
            'weapon_type' => $weapon->getType(),
            'cost' => Utils::decimalToNumber($final['cost'], 4)
        ));
    }

    public static function addBondTheoryToResult(Search $search, $creature, $result, $final) {
        if (!$search->getBondTheory() || $creature == null) {
            return $result;
        }

        return array_merge($result, array(
            'profit' => toNumber($final['profit']),
            'profit_mod' => toNumber($final['profit_mod']),
            'bond_min' => toNumber($final['bond_min']),
            'bond_max' => toNumber($final['bond_max'])
        ));
    }

    public static function addMaximizeColumns(Search $search, $result, Weapon $weapon, Amplifier $amp, $final) {
        if (!$search->getMaximize()) {
            return $result;
        }

        // when maximized, group these with the other skill based columns instead
        unset($result['hitmax']);
        unset($result['dmgmax']);

        if ($weapon->getSib() == 1) {
            $weapon_sib = "Yes";
        }
        else {
            $weapon_sib = "No";
        }

        $append = array(
            'amp_decay_per_sec' => toNumber($final['amp_decay_per_sec']),
            'amp_decay' => toNumber($amp->getDecay()),
            'amp_burn' => toNumber($amp->getBurn()),
            'weight' => $weapon->getWeight(),
            'power' => $weapon->getPower(),
            'maxtt' => $weapon->getMaxTt(),
            'mintt' => $weapon->getMinTt(),
            'uses' => $weapon->getUses(),
            'dmgstb' => $weapon->getDamageStab(),
            'dmgcut' => $weapon->getDamageCut(),
            'dmgimp' => $weapon->getDamageImpale(),
            'dmgpen' => $weapon->getDamagePenetrate(),
            'dmgshr' => $weapon->getDamageShear(),
            'dmgbrn' => $weapon->getDamageBurn(),
            'dmgcld' => $weapon->getDamageCold(),
            'dmgacd' => $weapon->getDamageAcid(),
            'dmgelc' => $weapon->getDamageElectricity(),
            'sib' => $weapon_sib,
            'hitprof' => $weapon->getHitProfession(),
            'hitrec' => $weapon->getHitRecommended(),
            'hitmax' => $weapon->getHitMax(),
            'dmgprof' => $weapon->getDamageProfession(),
            'dmgrec' => $weapon->getDamageRecommended(),
            'dmgmax' => $weapon->getDamageMax(),
            'source' => $weapon->getSource(),
            'discovered' => $weapon->getDiscovered(),
            'found' => $weapon->getFound(),
        );

        return array_merge($result, $append);
    }

    public static function unsetMarkup($result, Search $search) {
        if (!$search->getUseAmpMarkup()) {
            unset($result['amp_markup']);
        }
        if (!$search->getUseWeaponMarkup()) {
            unset($result['weapon_markup']);
        }

        return $result;
    }

    public static function unsetForAmp($result, Weapon $weapon, $amplifiers) {
        if (Merger::ampIsUsed($weapon, $amplifiers)) {
            return $result;
        }

        unset($result['amp_damage']);
        unset($result['amp_decay']);
        unset($result['amp_decay_per_sec']);
        unset($result['amp_burn']);

        return $result;
    }

    public static function unsetForCreature($result, $creature) {
        if ($creature != null) {
            return $result;
        }

        unset($result['time']);
        unset($result['cost']);
        unset($result['health_effective']);

        return $result;
    }

    private static function ampIsUsed(Weapon $weapon, $amplifiers) {
        if (!array_key_exists($weapon->getType(), $amplifiers)) {
            return false;
        }

        return $amplifiers[$weapon->getType()] != null;
    }
}
