<?php

include("../include/config.php");
include("../include/dao.php");

class Import {
    private $_table = null;
    
    function execute($table, $file, $match, $skip = null) {
        $this->_table = $table;
        
        $handle = @fopen($file, "r");
        $inserted = 0;
        $updated = 0;
        
        $new = array();
        
        if (!$handle) {
            die("could not open file '$file'");
        }
        
        while (($buffer = fgets($handle, 4096)) !== false) {
          $attrs = explode(';', $buffer);
    
          if ($attrs == null || $attrs == "" || count($attrs) < 2) {
            continue;
          }
    
          if ($skip !== null && $attrs[0] == $skip) {
            continue;
          }
          
          $values = array();
          
          foreach($match as $key => $value) {
              $values[$value] = $attrs[$key];
          }
    
          if ($this->exists($values)) {
              $updated++;
              Import::update($values, $this->_table);
          }
          else {
              array_push($new, $values['name']);
              $inserted++;
              Import::insert($values, $this->_table);
          }
        }
    
        if (!feof($handle)) {
          echo "Error: unexpected fgets() fail\n";
        }
    
        fclose($handle);
        
        return array(
            'updated' => $updated,
            'inserted' => $inserted,
            'new' => $new
        );
    }
    
    private function exists($values) {
        global $dao;
        
        $rs = Dao::execute($dao, "select * from $this->_table where name = ?", array($values['name']));

        if (isset($rs) && $rs != null && count($rs) != 0) {
            return true;
        }
      
        return false;
    }

    public static function createUpdateQuery($values) {
        $update = "";

        foreach ($values as $k => $v) {
            if (trim($v) == "") {
                continue;
            }
            $update .= "`$k` = (:$k), ";
        }

        return rtrim($update, ', ');
    }

    public static function createInsertQuery($values) {
        $columns = "(";
        $insert = "(";

        foreach ($values as $k => $v) {
            $columns .= "`$k`, ";
            $insert .= "?, ";
        }

        $columns = rtrim($columns, ', ') . ")";
        $insert = rtrim($insert, ', ') . ")";

        return array($columns, $insert);
    }

    public static function update($values, $table) {
        global $dao;

        $name = $values['name'];
        unset($values['name']);

        $query = "update $table ";
        $update = Import::createUpdateQuery($values);
        $query .= "set $update where `name` = (:name)";

        $values['name'] = $name;
        $tvalues = array();

        foreach ($values as $k => $v) {
            if (trim($v) == "") {
                continue;
            }

            $tvalues[$k] = trim($v);
        }

        Dao::update($dao, $query, $tvalues);
    }
    
    public static function insert($values, $table) {
        global $dao;

        $query = "insert into $table ";
        $columns = import::createinsertquery($values);
        $query .= "{$columns[0]} values {$columns[1]}";

        Dao::insert($dao, $query, array_values($values)); 
    }
}

?>
