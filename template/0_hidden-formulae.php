
<table class="formula">
    <tr>
        <td>Cost</td>
        <td>=</td>
        <td>AmmoCost</td>
        <td>+</td>
        <td>AmpDecay</td>
        <td>+</td>
        <td>WeaponDecay</td>
        <td>+</td>
        <td>Overkill</td>
        <?php if ($use_enhancer_decay) { ?>
            <td>+</td>
            <td>EnhancerDecay</td>
        <?php } ?>
    </tr>
    <tr>
        <td><?=$calc_cost / 100?> PED</td>
        <td>=</td>
        <td><?=n($_ammo_cost)?></td>
        <td>+</td>
        <td><?=$amp_decay?></td>
        <td>+</td>
        <td><?=$weapon_decay?></td>
        <td>+</td>
        <td><?=$overkill_cost?></td>
        <?php if ($use_enhancer_decay) { ?>
            <td>+</td>
            <td><?=n($enhancer_cost)?></td>
        <?php } ?>
    </tr>
</table>

<br />

<table class="formula">
    <tr>
        <td>EffectiveDamage</td>
        <td>=</td>
        <td>AverageDamage</td>
        <td>*</td>
        <td>HitRate</td>
        <td>+</td>
        <td colspan="9">AverageCritDamage</td>
    </tr>
    <tr>
        <td>EffectiveDamage</td>
        <td>=</td>
        <td>
            (DamageFrom + DamageTo)/2
        </td>
        <td>*</td>
        <td>
            (0.8 + HitProf/100/10)
        </td>
        <td>+</td>
        <td>
            (MaxDamage
        </td>
        <td>
            *
        </td>
        <td colspan="5">
            (CritRate
        </td>
        <td>
            +
        </td>
        <td>
            CritRateBonus)) * CritDamageBonus
        </td>
    </tr>
    <tr>
        <td>EffectiveDamage</td>
        <td>=</td>
        <td>
            (DamageFrom + DamageTo)/2
        </td>
        <td>*</td>
        <td>
            (0.8 + HitProf/100/10)
        </td>
        <td>
            +
        </td>
        <td>
            (MaxDamage
        </td>
        <td>
            *
        </td>
        <td>
            ((AccuracyEnhancerBonus
        </td>
        <td>
            *
        </td>
        <td>
            CritAbility
        </td>
        <td>
            +
        </td>
        <td>
            1) / 100
        </td>
        <td>
            +
        </td>
        <td>
            CritRateBonus)) * CritDamageBonus
        </td>
    </tr>
    <tr>
        <td><?=$effective_damage?></td>
        <td>=</td>
        <td>
            (<?=$damage_from?>+<?=$damage_to?>)/2
        </td>
        <td>*</td>
        <td>
            (0.8+<?=$hit_profession?>/100/10)
        </td>
        <td>+</td>
        <td>
            (<?=$max_dmg?>
        </td>
        <td>
            *
        </td>
        <td>
            ((<?=$critical_enhancer_bonus?>/100
        </td>
        <td>*</td>
        <td>
            Sqrt(<?=$hit_profession?>)/10
        </td>
        <td>
            +
        </td>
        <td>
            1) / 100
        </td>
        <td>
            +
        </td>
        <td>
            <?=$critical_hit_rate_bonus?>)) * (<?=$critical_hit_damage_bonus?>/2/100+1)
        </td>
    </tr>
    <tr>
        <td><?=$effective_damage?></td>
        <td>=</td>
        <td>
            <?=(($damage_from+$damage_to)/2)?>
        </td>
        <td>*</td>
        <td>
            <?=(0.8+$hit_profession/100/10)?>
        </td>
        <td>+</td>
        <td>
            <?=$max_dmg?>
        </td>
        <td>
            *
        </td>
        <td colspan="7">
            <?=(($critical_enhancer_bonus/100 * sqrt($hit_profession)/10 + 1)/100 + $critical_hit_rate_bonus) * ($critical_hit_damage_bonus/2/100+1)?>
        </td>
    </tr>
</table>
