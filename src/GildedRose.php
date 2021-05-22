<?php

namespace Runroom\GildedRose;

class GildedRose
{

    private array $items;

    function __construct(array $items)
    {
        $this->items = $items;
    }

    function updateQuality()
    {
        foreach ($this->items as $item) {
            $this->updateItem($item);
        }
    }

    public function updateItem(Item $item): void
    {
        if ($this->isAgedBrie($item)) {
            $this->updateAgedBrieItem($item);
        } elseif ($this->isBackstagePasses($item)) {
            $this->updateBackstagePassesItem($item);
        } elseif ($this->isSulfuras($item)) {

        } else {
            $this->updateNormalItem($item);
        }
    }


    private function isAgedBrie(Item $item): bool
    {
        return $item->name === 'Aged Brie';
    }


    private function isBackstagePasses(Item $item): bool
    {
        return $item->name === 'Backstage passes to a TAFKAL80ETC concert';
    }


    private function isSulfuras(Item $item): bool
    {
        return $item->name === 'Sulfuras, Hand of Ragnaros';
    }


    private function decreaseItemQuality(Item $item): void
    {
        if ($item->quality > 0) {
            $item->quality = $item->quality - 1;
        }
    }

    private function increaseItemQuality(Item $item): void
    {
        if ($item->quality < 50) {
            $item->quality = $item->quality + 1;
        }
    }

    /**
     * @param Item $item
     */
    private function decreaseItemSellIn(Item $item): void
    {
        $item->sell_in = $item->sell_in - 1;
    }

    /**
     * @param Item $item
     */
    private function updateAgedBrieItem(Item $item): void
    {
        $this->increaseItemQuality($item);
        if ($item->sell_in <= 0) {
            $this->increaseItemQuality($item);
        }
        $this->decreaseItemSellIn($item);
    }

    /**
     * @param Item $item
     */
    private function updateBackstagePassesItem(Item $item): void
    {
        $this->increaseItemQuality($item);
        if ($item->sell_in <= 10) {
            $this->increaseItemQuality($item);
        }
        if ($item->sell_in <= 5) {
            $this->increaseItemQuality($item);
        }
        if ($item->sell_in <= 0) {
            $item->quality = 0;
        }
        $this->decreaseItemSellIn($item);
    }

    /**
     * @param Item $item
     */
    private function updateNormalItem(Item $item): void
    {
        $this->decreaseItemQuality($item);
        if ($item->sell_in <= 0) {
            $this->decreaseItemQuality($item);
        }
        $this->decreaseItemSellIn($item);
    }
}
