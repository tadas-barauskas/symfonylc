<?php
namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="basketitems")
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\BasketItemRepository")
 */
class BasketItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Basket", inversedBy="basketItems")
     * @ORM\JoinColumn(name="basket_id", referencedColumnName="id")
     */
    private $basket;

    /**
     * @ORM\ManyToOne(targetEntity="Gadget")
     * @ORM\JoinColumn(name="gadget_id", referencedColumnName="id")
     */
    private $gadget;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount = 0;

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
     * Set amount
     *
     * @param integer $amount
     *
     * @return BasketItem
     */
    public function setAmount($amount)
    {
        $this->amount += $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set basket
     *
     * @param \ShopBundle\Entity\Basket $basket
     *
     * @return BasketItem
     */
    public function setBasket(\ShopBundle\Entity\Basket $basket = null)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return \ShopBundle\Entity\Basket
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * Set gadget
     *
     * @param \ShopBundle\Entity\Gadget $gadget
     *
     * @return BasketItem
     */
    public function setGadget(\ShopBundle\Entity\Gadget $gadget = null)
    {
        $this->gadget = $gadget;

        return $this;
    }

    /**
     * Get gadget
     *
     * @return \ShopBundle\Entity\Gadget
     */
    public function getGadget()
    {
        return $this->gadget;
    }

    public function getPrice()
    {
        return $this->getGadget()->getPrice() * $this->getAmount();
    }
}
