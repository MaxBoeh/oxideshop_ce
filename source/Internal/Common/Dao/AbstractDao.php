<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Common\Dao;

use PDO;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Abstract class for data access objects.
 */
abstract class AbstractDao
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * AbstractDao constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Method returns query builder.
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        $this->connection->setFetchMode(PDO::FETCH_ASSOC);

        return $this->connection->createQueryBuilder();
    }
}
