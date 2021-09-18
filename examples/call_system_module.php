<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new \Meklis\SwCoreClient\Client();

$req = \Meklis\SwCoreClient\Objects\Request::init(
    (new \Meklis\SwCoreClient\Objects\Device())->setIp('10.1.1.11')->setCommunity('public'),
    "system"
);

$resp = $client->call($req);

print_r($resp);
/*
Meklis\SwCoreClient\Objects\Response Object
(
    [error:protected] =>
    [request:protected] => Meklis\SwCoreClient\Objects\Request Object
        (
            [device:protected] => Meklis\SwCoreClient\Objects\Device Object
                (
                    [ip:protected] => 10.1.1.11
                    [community:protected] => public
                    [login:protected] =>
                    [password:protected] =>
                    [meta:protected] =>
                )

            [module:protected] => system
            [arguments:protected] => Array
                (
                )

        )

    [response:protected] => Array
        (
            [descr] => D-Link DES-3200-28 Fast Ethernet Switch
            [uptime] => 11d 0h 12min 35sec
            [contact] => admin@email
            [name] => switch-name
            [location] => location
            [meta] => Array
                (
                    [type] => SWITCH
                    [name] => D-link DES-3200-28/A1
                    [detect] => Array
                        (
                            [description] => ^D-Link DES-3200-28 Fast Ethernet Switch$
                            [objid] => ^.*113.1.3$
                        )

                    [ports] => 28
                    [extra] => Array
                        (
                            [diag_linkup] =>
                            [telnet_conn_type] => dlink
                        )

                    [modules] => Array
                        (
                            [0] => fdb
                            [1] => link_info
                            [2] => counters
                            [3] => system
                            [4] => vlans
                            [5] => cable_diag
                            [6] => errors
                            [7] => rmon
                            [8] => pvid
                            [9] => clear_counters
                            [10] => save_config
                            [11] => reboot
                            [12] => vlans_by_port
                            [13] => ctrl_port_state
                            [14] => ctrl_port_speed
                            [15] => ctrl_port_descr
                            [16] => ctrl_vlan_state
                            [17] => ctrl_vlan_port
                        )

                )

        )

)

 */