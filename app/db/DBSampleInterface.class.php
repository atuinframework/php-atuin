<?php
require_once('libs/db/DBInterface.class.php');

class DBSampleInterface extends DBInterface {
    private $tables = array(
        'province' => 'province',
        'region' => 'region'
    );

    /**********************************************
     **				   Province					 **
     **********************************************/
    function province_insert($kv_fields) {
        return $this->insert_kv($this->tables['province'], $kv_fields);
    }

    function province_select($where="", $order="") {
        $q = "SELECT * FROM {$this->tables['province']} $where $order";
        return $this->exec($q, MYSQLI_ASSOC);
    }

    function province_select_with_join($where="", $order="") {
        $q = "SELECT `p`.*,
					 `r`.`region`
			  FROM `{$this->tables['province']}` AS `p`
			  LEFT JOIN `{$this->tables['region']}` AS `r`
			  ON `p`.`region` = `r`.`id`
			  $where
			  $order";
        pprint($q);
        die();
        return $this->exec($q, MYSQLI_ASSOC);
    }

    function province_update($id, $kv_fields) {
        return $this->update_kv(
            $this->tables['province'], $kv_fields, "WHERE `id`='$id'");
    }

    function province_delete($id) {
        $where = "WHERE `id`='$id'";
        return $this->delete($this->tables['province'], $where);
    }

    /**********************************************
     **				    Region					 **
     **********************************************/
    function region_insert($kv_fields) {
        return $this->insert_kv($this->tables['region'], $kv_fields);
    }

    function region_select($where="", $order="") {
        $q = "SELECT * FROM `{$this->tables['region']}` $where $order";
        return $this->exec($q, MYSQLI_ASSOC);
    }

    function region_update($id, $kv_fields) {
        return $this->update_kv(
            $this->tables['region'], $kv_fields, "WHERE `id`='$id'");
    }

    function region_delete($id) {
        $where = "WHERE `id`='$id'";
        return $this->delete($this->tables['region'], $where);
    }
}

?>
