<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'C1.' . $_EXTKEY,
	'Node',
	'List/Edit nodes'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'C1.' . $_EXTKEY,
	'Ip4',
	'List/Edit IPv4 addresses'
);


// hooks for the backend
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['extkey'] = 'C1\\Nodedb\\Hooks\\TCEMainHook';
//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['extkey'] = 'C1\\Nodedb\\Hooks\\TCEMainHook';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'nodedb');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nodedb_domain_model_node', 'EXT:nodedb/Resources/Private/Language/locallang_csh_tx_nodedb_domain_model_node.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nodedb_domain_model_node');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nodedb_domain_model_ip4', 'EXT:nodedb/Resources/Private/Language/locallang_csh_tx_nodedb_domain_model_ip4.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nodedb_domain_model_ip4');
