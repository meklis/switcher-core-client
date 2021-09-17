<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new \Meklis\SwCoreClient\Client();
$resp = $client->getModelByKey('d_link_des_3200_28_a1');


var_dump($resp);
/* var_dump print
object(Meklis\SwCoreClient\Objects\DeviceModelData)#9 (7) {
  ["name":protected]=>
  string(21) "D-link DES-3200-28/A1"
  ["key":protected]=>
  string(21) "d_link_des_3200_28_a1"
  ["ports":protected]=>
  int(28)
  ["extra":protected]=>
  array(2) {
    ["diag_linkup"]=>
    bool(false)
    ["telnet_conn_type"]=>
    string(5) "dlink"
  }
  ["detect":protected]=>
  array(2) {
    ["description"]=>
    string(41) "^D-Link DES-3200-28 Fast Ethernet Switch$"
    ["objid"]=>
    string(11) "^.*113.1.3$"
  }
  ["device_type":protected]=>
  string(6) "SWITCH"
  ["modules":protected]=>
  array(18) {
    [0]=>
    string(3) "fdb"
    [1]=>
    string(9) "link_info"
    [2]=>
    string(8) "counters"
    [3]=>
    string(6) "system"
    [4]=>
    string(5) "vlans"
    [5]=>
    string(10) "cable_diag"
    [6]=>
    string(6) "errors"
    [7]=>
    string(4) "rmon"
    [8]=>
    string(4) "pvid"
    [9]=>
    string(14) "clear_counters"
    [10]=>
    string(11) "save_config"
    [11]=>
    string(6) "reboot"
    [12]=>
    string(13) "vlans_by_port"
    [13]=>
    string(15) "ctrl_port_state"
    [14]=>
    string(15) "ctrl_port_speed"
    [15]=>
    string(15) "ctrl_port_descr"
    [16]=>
    string(15) "ctrl_vlan_state"
    [17]=>
    string(14) "ctrl_vlan_port"
  }
}

 */