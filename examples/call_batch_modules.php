<?php
require __DIR__ . '/../vendor/autoload.php';

$client = new \Meklis\SwCoreClient\Client();

$reqs[] = \Meklis\SwCoreClient\Objects\Request::init(
    (new \Meklis\SwCoreClient\Objects\Device())->setIp('10.1.1.11')->setCommunity('public'),
    "system"
);

$reqs[] = \Meklis\SwCoreClient\Objects\Request::init(
    (new \Meklis\SwCoreClient\Objects\Device())->setIp('10.1.1.11')->setCommunity('public'),
    "fdb",
    ['interface' => 27]
);

$resp = $client->callBatch($reqs);

print_r($resp);
/*
Array
(
    [0] => Meklis\SwCoreClient\Objects\Response Object
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

                    [module:protected] =>
                    [arguments:protected] => Array
                        (
                        )

                )

            [response:protected] => Array
                (
                    [descr] => D-Link DES-3200-28 Fast Ethernet Switch
                    [uptime] => 11d 0h 14min 59sec
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

    [1] => Meklis\SwCoreClient\Objects\Response Object
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

                    [module:protected] =>
                    [arguments:protected] => Array
                        (
                            [interface] => 27
                        )

                )

            [response:protected] => Array
                (
                    [0] => Array
                        (
                            [interface] => Array
                                (
                                    [id] => 27
                                    [name] => 1/27
                                    [_key] => 27
                                )

                            [vlan_id] => 301
                            [mac] => B8:69:F4:03:E8:89
                            [status] => LEARNED
                        )

                )

        )

)

 */