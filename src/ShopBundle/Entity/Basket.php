<?php
namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 *
 * @ORM\Table(name="baskets")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\BasketRepository")
 */
class Basket
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="BasketItem", mappedBy="basket")
     */
    private $basketItems;

    /**
     * @var $timestamp $created
     *
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->basketItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \ShopBundle\Entity\User $user
     *
     * @return Basket
     */
    public function setUser(\ShopBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ShopBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add basketItem
     *
     * @param \ShopBundle\Entity\BasketItem $basketItem
     *
     * @return Basket
     */
    public function addBasketItem(\ShopBundle\Entity\BasketItem $basketItem)
    {
        $gadgetId = $basketItem->getGadgetId();
        if ($oldItem = $this->basketItems[$gadgetId]) {
            $basketItem->setAmount($basketItem->getAmount() + $oldItem->getAmount());
        }
        $this->basketItems[$basketItem->getGadgetId()] = $basketItem;

        return $this;
    }

    /**
     * Remove basketItem
     *
     * @param \ShopBundle\Entity\BasketItem $basketItem
     */
    public function removeBasketItem(\ShopBundle\Entity\BasketItem $basketItem)
    {
        $this->basketItems->removeElement($basketItem);
    }

    /**
     * Get basketItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBasketItems()
    {
        return $this->basketItems;
    }

    public function getBasketItem($gadgetId)
    {
        if (isset($this->basketItems[$gadgetId])) {
            return $this->basketItems[$gadgetId];
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function updateTimestamp()
    {
        $this->timestamp = new \DateTime();
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Basket
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
