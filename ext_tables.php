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
	'Ip',
	'ListEdit IPs'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'nodedb');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nodedb_domain_model_node', 'EXT:nodedb/Resources/Private/Language/locallang_csh_tx_nodedb_domain_model_node.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nodedb_domain_model_node');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_nodedb_domain_model_ip', 'EXT:nodedb/Resources/Private/Language/locallang_csh_tx_nodedb_domain_model_ip.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_nodedb_domain_model_ip');
