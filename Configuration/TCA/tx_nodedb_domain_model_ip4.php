<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_ip4',
		'label' => 'ipaddr',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		//'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'anycast,ipaddr,netmask,comment,node,owners',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('nodedb') . 'Resources/Public/Icons/tx_nodedb_domain_model_ip4.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, anycast, ipaddr, netmask, comment, node, owners',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, anycast,ipaddr, netmask, comment, node, owners,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

        // @ToDo may be removed after import of all nodes
        'crdate' => Array (
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'Erstellungsdatum',
            'config' => Array (
                'type' => 'input',
                'size' => '8',
                'max' => '20',
                'eval' => 'date',
                'checkbox' => '0',
                'default' => '0'
            )
        ),
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_nodedb_domain_model_ip4',
				'foreign_table_where' => 'AND tx_nodedb_domain_model_ip4.pid=###CURRENT_PID### AND tx_nodedb_domain_model_ip4.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
        'anycast' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_ip4.anycast',
            'config' => array(
                'type' => 'check',
            ),
        ),
		'ipaddr' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_ip4.ipaddr',
			'config' => array(
				'type' => 'input',
				'size' => 16,
				'eval' => 'trim,required,unique'
			),
		),
        'network_first' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_ip4.networkFirst',
            'config' => array(
                'type' => 'input',
                'size' => 16,
                'eval' => 'trim,required,unique'
            ),
        ),
        'network_last' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_ip4.networkLast',
            'config' => array(
                'type' => 'input',
                'size' => 16,
                'eval' => 'trim,required,unique'
            ),
        ),
		'netmask' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_ip4.netmask',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
        'comment' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_ip4.comment',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
		'node' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_ip4.node',
			'config' => array(
				'type' => 'select',
                'internal_type' => 'db',
				'foreign_table' => 'tx_nodedb_domain_model_node',
                'foreign_table_field' => 'ips',
                'foreign_table_where' => ' AND tx_nodedb_domain_model_node.pid=###CURRENT_PID### ORDER BY tx_nodedb_domain_model_node.hostname ',
                'MM' => 'tx_nodedb_node_ipnode_mm',
                'MM_opposite_field' => 'ips',
                'MM_hasUidField' => 1,
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				//'multiple' => 1,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'module' => array(
							'name' => 'wizard_edit',
						),
						'type' => 'popup',
						'title' => 'Edit',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'module' => array(
							'name' => 'wizard_add',
						),
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_nodedb_domain_model_node',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
						),
					),
				),
			),
		),
        'owners' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:nodedb/Resources/Private/Language/locallang_db.xlf:tx_nodedb_domain_model_node.owners',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'fe_users',
                'MM' => 'tx_nodedb_ip_frontenduser_mm',
                'size' => 10,
                'autoSizeMax' => 30,
                'maxitems' => 9999,
                'multiple' => 0,
                'wizards' => array(
                    '_PADDING' => 1,
                    '_VERTICAL' => 1,
                    'edit' => array(
                        'module' => array(
                            'name' => 'wizard_edit',
                        ),
                        'type' => 'popup',
                        'title' => 'Edit',
                        'icon' => 'edit2.gif',
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
                    ),
                    'add' => Array(
                        'module' => array(
                            'name' => 'wizard_add',
                        ),
                        'type' => 'script',
                        'title' => 'Create new',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table' => 'fe_users',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ),
                    ),
                ),
            ),
        ),
	),
);