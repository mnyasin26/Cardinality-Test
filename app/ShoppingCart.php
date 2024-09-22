<?php

namespace App;

use Exception;

class ShoppingCart
{
    private $items = [];

    /**
     * Menambahkan item ke keranjang belanja.
     *
     * @param string $itemName Nama item.
     * @param float  $price    Harga per unit.
     * @param int    $quantity Jumlah item.
     */
    public function addItem($itemName, $price, $quantity = 1)
    {

        if ($quantity <= 0) {
            throw new Exception('Quantity must be greater than 0.');
        }

        if (isset($this->items[$itemName])) {
            // Jika item sudah ada, tambahkan kuantitasnya.
            $this->items[$itemName]['quantity'] += $quantity;
        } else {
            // Jika item belum ada, tambahkan sebagai item baru.
            $this->items[$itemName] = [
                'price'    => $price,
                'quantity' => $quantity,
            ];
        }
    }

    /**
     * Menghapus item dari keranjang belanja.
     *
     * @param string $itemName Nama item yang akan dihapus.
     */
    public function removeItem($itemName)
    {
        unset($this->items[$itemName]);
    }

    /**
     * Mendapatkan total kuantitas semua item.
     *
     * @return int Total kuantitas.
     */
    public function getTotalQuantity()
    {
        $totalQuantity = 0;
        foreach ($this->items as $item) {
            $totalQuantity += $item['quantity'];
        }
        return $totalQuantity;
    }

    /**
     * Mendapatkan total harga semua item.
     *
     * @return float Total harga.
     */
    public function getTotalPrice()
    {
        $totalPrice = 0.0;
        foreach ($this->items as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return $totalPrice;
    }

    /**
     * Mendapatkan daftar semua item dalam keranjang.
     *
     * @return array Daftar item.
     */
    public function getItems()
    {
        return $this->items;
    }
}
