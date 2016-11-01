<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'C1.' . $_EXTKEY,
	'Node',
	array(
		'Node' => 'list, manage, show, new, create, edit, update, delete, error',
		
	),
	// non-cacheable actions
	array(
		'Node' => 'new, manage, create, edit, update, delete',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'C1.' . $_EXTKEY,
	'Ip4',
	array(
		'Ip4' => 'list, manage, show, new, create, edit, update, delete, error',
		
	),
	// non-cacheable actions
	array(
		'Ip4' => 'new, manage, create, edit, update, delete',
		
	)
);
