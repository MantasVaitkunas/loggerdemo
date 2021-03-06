<?php
/**
 * This file is part of OXID eShop Logger Demo module.
 * Logger Demo module is free software:
 * you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * Logger Demo module is distributed in
 * the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Logger Demo module.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * @category      module
 * @package       loggerdemo
 * @author        OXID eSales AG
 * @link          http://www.oxid-esales.com/en/
 * @copyright (C) OXID e-Sales, 2003-2015
 */

use OxidEsales\EventLoggerDemo\BasketItemLogger;

/**
 * Test class for checking if logger correctly integrates with shop via bridge.
 */
class LogAddToBasketTest extends oxUnitTestCase
{
    /**
     * Test creates virtual directory and checks if required information was logged.
     */
    public function testChecksWhenCustomerClicksAddToBasket()
    {
        $articleId = 'testArticleId';
        $basketComponent = oxNew('oxcmp_basket');
        $this->setRequestParameter('aid', $articleId);

        $vfsStreamWrapper = $this->getVfsStreamWrapper();
        $vfsStreamWrapper->createStructure(array('log' => array()));
        $this->getConfig()->setConfigParam('sShopDir', $vfsStreamWrapper->getRootPath());
        $basketComponent->tobasket();
        $fakeBasketLogFile = $vfsStreamWrapper->getRootPath() . 'log' . DIRECTORY_SEPARATOR . BasketItemLogger::FILE_NAME;
        $fileContents = file_get_contents($fakeBasketLogFile);

        $this->assertTrue((bool)strpos($fileContents, $articleId));
    }
}
