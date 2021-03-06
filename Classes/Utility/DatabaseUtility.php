<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Benjamin Mack <benni@typo3.org>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Utility class for handling Database Connection
 * for several TYPO3 versions
 * This is needed as the TYPO3 Connection handling is different in 6.1+
 * and the DCE extensions needs to connect to the DB at
 * startup time (ext_localconf.php)
 *
 * @package dce
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_Dce_Utility_DatabaseUtility {

	/**
	 * Returns a valid DatabaseConnection object that is connected and ready to be
	 * used static
	 * @return t3lib_DB
	 */
	public static function getDatabaseConnection() {
		if (!$GLOBALS['TYPO3_DB']) {
			// for 6.1+, only initialize the global DB object
			if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) >= 6001000) {
				\TYPO3\CMS\Core\Core\Bootstrap::getInstance()->initializeTypo3DbGlobal();
			} else {
				// 6.0 and below: create and connect (no implicit connection available)
				/** @var $TYPO3_DB t3lib_DB */
				$GLOBALS['TYPO3_DB'] = t3lib_div::makeInstance('t3lib_DB');
				$GLOBALS['TYPO3_DB']->connectDB();
			}
		}
		return $GLOBALS['TYPO3_DB'];
	}
}