<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'C1.' . $_EXTKEY,
	'Node',
	array(
		'Node' => 'list, show, new, edit, delete',
		
	),
	// non-cacheable actions
	array(
		'Node' => 'new, edit, delete',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'C1.' . $_EXTKEY,
	'Ip',
	array(
		'Ip' => 'list, show, new, edit, delete',
		
	),
	// non-cacheable actions
	array(
		'Ip' => 'new, edit, delete',
		
	)
);
