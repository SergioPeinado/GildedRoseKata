<?php

namespace Runroom\GildedRose;

class GildedRose
{

    const AGED_BRIE = 'Aged Brie';
    const BACKSTAGE_PASSES = 'Backstage passes to a TAFKAL80ETC concert';
    const SULFURAS = 'Sulfuras, Hand of Ragnaros';

    private array $items;

    function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $this->updateItem($item);
        }
    }

    private function updateItem(Item $item): void
    {
        switch ($item->name) {
            case self::AGED_BRIE:
                $this->updateAgedBrieItem($item);
                break;
            case self::BACKSTAGE_PASSES:
                $this->updateBackstagePassesItem($item);
                break;
            case self::SULFURAS:
                break;
            default:
                $this->updateNormalItem($item);
        }
    }


    private function updateAgedBrieItem(Item $item): void
    {
        $this->increaseItemQuality($item);
        if ($item->sell_in <= 0) {
            $this->increaseItemQuality($item);
        }
        $this->decreaseItemSellIn($item);
    }


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


    private function updateNormalItem(Item $item): void
    {
        $this->decreaseItemQuality($item);
        if ($item->sell_in <= 0) {
            $this->decreaseItemQuality($item);
        }
        $this->decreaseItemSellIn($item);
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


    private function decreaseItemSellIn(Item $item): void
    {
        $item->sell_in = $item->sell_in - 1;
    }
}
