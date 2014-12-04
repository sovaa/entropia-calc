<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');

require_once('dao.php');

class Manager {
  function pushWeaponArray($rs) {
    $results = array();
    foreach ($rs as $value) {
      array_push($results, array(
        'id' => $value['id'],
        'name' => $value['name'],
        'class' => $value['class'],
        'type' => $value['type'],
        'weight' => $value['weight'],
        'damage' => $value['damage'],
        'range' => $value['range'],
        'attacks' => $value['attacks'],
        'power' => $value['power'],
        'decay' => $value['decay'],
        'burn' => $value['burn'],
        'maxtt' => $value['maxtt'],
        'mintt' => $value['mintt'],
        'markup' => $value['markup'],
        'uses' => $value['uses'],
        'dmgstb' => $value['dmgstb'],
        'dmgcut' => $value['dmgcut'],
        'dmgimp' => $value['dmgimp'],
        'dmgpen' => $value['dmgpen'],
        'dmgshr' => $value['dmgshr'],
        'dmgbrn' => $value['dmgbrn'],
        'dmgcld' => $value['dmgcld'],
        'dmgacd' => $value['dmgacd'],
        'dmgelc' => $value['dmgelc'],
        'sib' => $value['sib'],
        'hitprof' => $value['hitprof'],
        'hitrec' => $value['hitrec'],
        'hitmax' => $value['hitmax'],
        'dmgprof' => $value['dmgprof'],
        'dmgrec' => $value['dmgrec'],
        'dmgmax' => $value['dmgmax'],
        'source' => $value['source'],
        'discovered' => $value['discovered'],
        'found' => $value['found'],
      ));
    }
    return $results;
  }

  function getWeapon($id) {
    if ($id == null) {
      return array();
    }

    global $dao;
    $rs = Dao::execute($dao, "select * from weapon where id = ?", array($id));
    $results = $this->pushWeaponArray($rs);
    return $results[0];
  }

  function getSights() {
    return $this->getSightOrScope(null, 'sight');
  }
  
  function getScopes() {
    return $this->getSightOrScope(null, 'scope');
  }

  function getSight($id) {
    return $this->getSightOrScope($id, 'sight');
  }

  function getScope($id) {
    return $this->getSightOrScope($id, 'scope');
  }

  function getSightOrScope($id, $type) {
    if ($id != null && $id == '--') {
      return array();
    }

    global $dao;

    if ($id == null) {
        $rs = Dao::execute($dao, "select * from attachment where type = ?", array($type));
    }
    else {
        $rs = Dao::execute($dao, "select * from attachment where type = '$type' and id = ?", array($id));
    }

    $result = array();

    foreach ($rs as $value) {
      array_push($result, array(
        'id' => $value['id'],
        'name' => $value['name'],
        'skillmod' => $value['skillmod'],
        'skillbonus' => $value['skillbonus'],
        'zoom' => $value['zoom'],
        'decay' => $value['decay'],
        'critchance' => $value['critchance'],
        'critdamage' => $value['critdamage'],
        'markup' => $value['markup']
      ));
    }

    if ($id != null) {
      return $result[0];
    }

    return $result;
  }

  function getAmp($id) {
    if ($id == null || $id == '--') {
      return array();
    }

    global $dao;

    $rs = Dao::execute($dao, "select * from amp where id = ?", array($id));
    $result = null;

    foreach ($rs as $value) {
      $result = array(
        'id' => $value['id'],
        'name' => $value['name'],
        'type' => $value['type'],
        'decay' => $value['decay'],
        'damage' => $value['damage'],
        'burn' => $value['burn'],
        'markup' => 100,
      );

      break;
    }

    return $result;
  }

  function getCreature($id) {
    if ($id == null) {
      return array();
    }

    global $dao;

    $rs = Dao::execute($dao, "select * from creature where id = ?", array($id));
    $result = null;

    foreach ($rs as $value) {
      $result = array(
        'id' => $value['id'],
        'name' => $value['name'],
        'hp' => $value['hp'],
        'regen' => $value['regen'],
        'maturity' => $value['maturity'],
        'damage' => $value['damage'],
        'threat' => $value['threat']
      );

      break;
    }

    return $result;
  }

  function getTypes() {
    global $dao;

    $rs = Dao::execute($dao, "select distinct type from weapon order by type asc");
    $results = array();

    foreach ($rs as $r) {
      array_push($results, $r['type']);
    }

    return $results;
  }

  function getWeaponEnhancers() {
    global $dao;

    $rs = Dao::execute($dao, "select * from weaponenhancer order by id asc");
    $results = array();

    foreach ($rs as $r) {
      array_push($results, array(
            'name' => $r['name'],
            'slot' => floatval($r['socket']) - 1,
            'tt' => $r['tt'],
            'markup' => $r['markup']
      ));
    }

    return $results;
  }

  function getClasses() {
    global $dao;

    $rs = Dao::execute($dao, "select distinct class from weapon order by class asc");
    $results = array();

    foreach ($rs as $r) {
      if (trim($r['class']) === '') {
        continue;
      }

      array_push($results, $r['class']);
    }

    return $results;
  }

  function getWeapons() {
    global $dao;
    $rs = Dao::execute($dao, "select * from weapon order by name asc");
    return $this->pushWeaponArray($rs);
  }

  function getEnergyAmps() {
    return $this->getAmps('Laser');
  }

  function getBlpAmps() {
    return $this->getAmps('BLP');
  }

  function getAmps($type) {
    global $dao;

    $rs = Dao::execute($dao, "select * from amp where type = ? order by name asc", array($type));
    $results = array();

    foreach ($rs as $value) {
      array_push($results, array(
        'id' => $value['id'],
        'name' => $value['name'],
        'type' => $value['type'],
        'decay' => $value['decay'],
        'damage' => $value['damage'],
        'burn' => $value['burn'],
        'markup' => 0
      ));
    }

    return $results;
  }

  function getMedicalTools() {
    global $dao;

    $rs = Dao::execute($dao, "select * from tool order by name asc");
    $results = array();

    foreach ($rs as $value) {
      array_push($results, array(
        'id' => $value['id'],
        'name' => $value['name'],
        'heal' => $value['heal'],
        'effective' => $value['effective'],
        'uses' => $value['uses'],
        'reload' => $value['reload'],
        'hps' => $value['hps'],
        'markup' => $value['markup'],
        'cost' => $value['cost'],
        'eco' => $value['eco'],
        'decay' => $value['decay'],
        'profession' => $value['profession'],
        'rec' => $value['rec'],
        'max' => $value['max'],
        'type' => $value['type']
      ));
    }

    return $results;
  }

  function getCreatures() {
    global $dao;
    $rs = Dao::execute($dao, "select * from creature where regen > 0 order by substring_index(name, ' ', 1) asc, maturity asc");
    $results = array();

    foreach ($rs as $value) {
      array_push($results, array(
        'id' => $value['id'],
        'name' => $value['name'],
        'hp' => $value['hp'],
        'regen' => $value['regen'],
        'maturity' => $value['maturity'],
        'damage' => $value['damage'],
        'threat' => $value['threat']
      ));
    }

    return $results;
  }
}

?>

