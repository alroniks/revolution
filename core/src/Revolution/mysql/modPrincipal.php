<?php

namespace MODX\Revolution\mysql;

abstract class modPrincipal extends \MODX\Revolution\modPrincipal
{
    public static $metaMap = [
        'package' => 'MODX\\Revolution\\',
        'version' => '3.0',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
        'tableMeta' =>
            [
                'engine' => 'InnoDB',
            ],
        'fields' =>
            [
            ],
        'fieldMeta' =>
            [
            ],
        'composites' =>
            [
                'Acls' =>
                    [
                        'class' => 'modAccess',
                        'local' => 'id',
                        'foreign' => 'principal',
                        'cardinality' => 'many',
                        'owner' => 'local',
                    ],
            ],
    ];

}
