<?php
/**
 * Created by PhpStorm.
 * User: mantas
 * Date: 28.03.18
 * Time: 16:30
 */

namespace OxidEsales\EshopCommunity\Tests\Unit\Internal\Common\Dao;

use Doctrine\DBAL\Connection;
use OxidEsales\EshopCommunity\Internal\Common\Dao\AbstractDao;
use PDO;

class AbstractDaoTest extends \PHPUnit_Framework_TestCase
{
    public function testIfReturnsQueryBuilder()
    {
        $queryBuilder = $this->getMockBuilder(\Doctrine\DBAL\Query\QueryBuilder::class)->disableOriginalConstructor();

        $connection = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $connection->method('createQueryBuilder')->willReturn($queryBuilder);

        $abstractDao = $this->getAbstractDao($connection);
        $this->assertSame($queryBuilder, $abstractDao->getQueryBuilder());
    }

    public function testIfCorrectFetchMode()
    {
        $connection = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $connection->expects($this->once())->method('setFetchMode')->with($this->equalTo(PDO::FETCH_ASSOC));

        $abstractDao = $this->getAbstractDao($connection);
        $abstractDao->getQueryBuilder();
    }

    /**
     * @param $connection
     * @return \PHPUnit_Framework_MockObject_MockObject|AbstractDao
     */
    private function getAbstractDao($connection)
    {
        $abstractDao = $this->getMockBuilder(AbstractDao::class)->setConstructorArgs([$connection])->getMockForAbstractClass();
        return $abstractDao;
    }
}
