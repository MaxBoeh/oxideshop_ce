<?php
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\EshopCommunity\Internal\Service;

use Doctrine\Common\Collections\ArrayCollection;
use OxidEsales\Eshop\Internal\Dao\RatingDaoInterface;
use OxidEsales\Eshop\Internal\Service\UserRatingServiceInterface;
use OxidEsales\EshopCommunity\Application\Model\Rating;

/**
 * Class UserRatingService
 * @internal
 * @package OxidEsales\EshopCommunity\Internal\Service
 */
class UserRatingService implements UserRatingServiceInterface
{
    /**
     * @var RatingDaoInterface
     */
    private $ratingDao;

    /**
     * UserRatingService constructor.
     * @param RatingDaoInterface $ratingDao
     */
    public function __construct(RatingDaoInterface $ratingDao)
    {
        $this->ratingDao = $ratingDao;
    }

    /**
     * Returns user ratings.
     *
     * @param string $userId
     *
     * @return ArrayCollection
     */
    public function getRatings($userId)
    {
        return $this->ratingDao->getRatingsByUserId($userId);
    }

    /**
     * Delete a Rating.
     *
     * @param string $userId
     * @param string $ratingId
     *
     * @return bool
     */
    public function deleteRating($userId, $ratingId)
    {
        return $this->ratingDao->deleteReview($userId, $ratingId);
    }
}
