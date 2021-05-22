<?php

namespace Runroom\GildedRose;

class GildedRose {

    private array $items;

    function __construct(array $items) {
        $this->items = $items;
    }

    function updateQuality() {
        foreach ($this->items as $item) {
            $this->updateItem($item);
        }
    }

    public function updateItem(Item $item): void
    {
        if ($this->isAgedBrie($item) and $this->isBackstagePasses($item)) {
            if ($item->quality > 0) {
                if ($this->isSulfuras($item)) {
                    $item->quality = $item->quality - 1;
                }
            }
        } else {
            if ($item->quality < 50) {
                $item->quality = $item->quality + 1;
                if (!$this->isBackstagePasses($item)) {
                    if ($item->sell_in < 11) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                    if ($item->sell_in < 6) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                }
            }
        }

        if ($this->isSulfuras($item)) {
            $item->sell_in = $item->sell_in - 1;
        }

        if ($item->sell_in < 0) {
            if ($this->isAgedBrie($item)) {
                if ($this->isBackstagePasses($item)) {
                    if ($item->quality > 0) {
                        if ($this->isSulfuras($item)) {
                            $item->quality = $item->quality - 1;
                        }
                    }
                } else {
                    $item->quality = 0;
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                }
            }
        }
    }


    private function isAgedBrie(Item $item): bool
    {
        return $item->name != 'Aged Brie';
    }

    private function isBackstagePasses(Item $item): bool
    {
        return $item->name != 'Backstage passes to a TAFKAL80ETC concert';
    }

    private function isSulfuras(Item $item): bool
    {
        return $item->name != 'Sulfuras, Hand of Ragnaros';
    }
}
