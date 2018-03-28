<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Common\Dao;
use PDO;

/**
 * Abstract class for data access objects.
 */
abstract class AbstractDao
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * AbstractDao constructor.
     * @param \Doctrine\DBAL\Connection $connection
     */
    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Method returns query builder.
     *
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function getQueryBuilder()
    {
        $this->connection->setFetchMode(PDO::FETCH_ASSOC);

        return $this->connection->createQueryBuilder();
    }
}
