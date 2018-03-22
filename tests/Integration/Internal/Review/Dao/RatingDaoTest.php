<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Internal\Review\Dao;

use OxidEsales\TestingLibrary\UnitTestCase;
use OxidEsales\EshopCommunity\Core\DatabaseProvider;
use OxidEsales\Eshop\Application\Model\Rating;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\EshopCommunity\Internal\Review\Dao\RatingDao;

class RatingDaoTest extends UnitTestCase
{
    public function testGetRatingsByUserId()
    {
        $ratingDao = $this->getRatingDao();

        $this->createTestRatingsForGetRatingsByUserIdTest();

        $ratings = $ratingDao->getRatingsByUserId('user1');

        $this->assertCount(2, $ratings->toArray());
    }

    public function testGetRatingsByProductId()
    {
        $ratingDao = $this->getRatingDao();

        $this->createTestRatingsForGetRatingsByProductIdTest();

        $ratings = $ratingDao->getRatingsByProductId('product1');

        $this->assertCount(2, $ratings->toArray());
    }

    public function testDeleteRating()
    {
        $ratingDao = $this->getRatingDao();

        $database = $this->getDatabase();

        $sqlId1 = "select oxid from oxratings where oxid = 'id1'";
        $sqlId2 = "select oxid from oxratings where oxid = 'id2'";

        $this->createTestRatingsForDeleteRatingTest();

        $this->assertEquals('id1', $database->getOne($sqlId1));
        $this->assertEquals('id2', $database->getOne($sqlId2));

        $ratingDao->deleteRating('user1', 'id1');

        $this->assertFalse($database->getOne($sqlId1));
        $this->assertEquals('id2', $database->getOne($sqlId2));
    }

    public function testDeleteRatingWrongUser()
    {
        $ratingDao = $this->getRatingDao();

        $database = $this->getDatabase();

        $sqlId1 = "select oxid from oxratings where oxid = 'id1'";
        $sqlId2 = "select oxid from oxratings where oxid = 'id2'";

        $this->createTestRatingsForDeleteRatingTest();

        $this->assertEquals('id1', $database->getOne($sqlId1));
        $this->assertEquals('id2', $database->getOne($sqlId2));

        $ratingDao->deleteRating('userWrongId', 'id1');

        $this->assertEquals('id1', $database->getOne($sqlId1));
        $this->assertEquals('id2', $database->getOne($sqlId2));
    }

    private function createTestRatingsForDeleteRatingTest()
    {
        $rating = oxNew(Rating::class);
        $rating->setId('id1');
        $rating->oxratings__oxuserid = new Field('user1');
        $rating->save();

        $rating = oxNew(Rating::class);
        $rating->setId('id2');
        $rating->oxratings__oxuserid = new Field('user1');
        $rating->save();
    }

    private function createTestRatingsForGetRatingsByUserIdTest()
    {
        $rating = oxNew(Rating::class);
        $rating->setId('id1');
        $rating->oxratings__oxuserid = new Field('user1');
        $rating->save();

        $rating = oxNew(Rating::class);
        $rating->setId('id2');
        $rating->oxratings__oxuserid = new Field('user1');
        $rating->save();

        $rating = oxNew(Rating::class);
        $rating->setId('id3');
        $rating->oxratings__oxuserid = new Field('userNotMatched');
        $rating->save();
    }

    private function createTestRatingsForGetRatingsByProductIdTest()
    {
        $rating = oxNew(Rating::class);
        $rating->setId('id1');
        $rating->oxratings__oxobjectid = new Field('product1');
        $rating->oxratings__oxtype = new Field('oxarticle');
        $rating->save();

        $rating = oxNew(Rating::class);
        $rating->setId('id2');
        $rating->oxratings__oxobjectid = new Field('product1');
        $rating->oxratings__oxtype = new Field('oxarticle');
        $rating->save();

        $rating = oxNew(Rating::class);
        $rating->setId('id3');
        $rating->oxratings__oxobjectid = new Field('productNotMatched');
        $rating->oxratings__oxtype = new Field('oxarticle');
        $rating->save();

        $rating = oxNew(Rating::class);
        $rating->setId('id4');
        $rating->oxratings__oxobjectid = new Field('product1');
        $rating->oxratings__oxtype = new Field('oxrecommlist');
        $rating->save();

    }

    private function getRatingDao()
    {
        return new RatingDao(
            $this->getDatabase()
        );
    }

    /**
     * @return \OxidEsales\Eshop\Core\Database\Adapter\DatabaseInterface
     */
    private function getDatabase()
    {
        return DatabaseProvider::getDb();
    }
}
