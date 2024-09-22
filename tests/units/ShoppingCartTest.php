<?php

namespace App;

use Exception;
use PHPUnit\Framework\TestCase;

class ShoppingCartTest extends TestCase
{

    private $cart;

    /**
     * Test untuk memastikan bahwa menambahkan item meningkatkan jumlah item dalam keranjang.
     */
    public function testAddItemIncreasesItemCount()
    {
        $cart = new ShoppingCart();
        $cart->addItem('Apel', 10000, 2);
        $cart->addItem('Pisang', 5000, 3);

        // Memastikan bahwa jumlah item dalam keranjang adalah 2.
        $this->assertCount(2, $cart->getItems());

        // Memastikan total kuantitas adalah 5 (2 Apel + 3 Pisang).
        $this->assertEquals(5, $cart->getTotalQuantity());

        // Memastikan total harga lebih besar dari 0.
        $this->assertGreaterThan(0, $cart->getTotalPrice());

        // Memastikan total kuantitas lebih besar atau sama dengan 5.
        $this->assertGreaterThanOrEqual(5, $cart->getTotalQuantity());

        // Memastikan total kuantitas kurang dari 10.
        $this->assertLessThan(10, $cart->getTotalQuantity());

        // Memastikan total kuantitas kurang atau sama dengan 5.
        $this->assertLessThanOrEqual(5, $cart->getTotalQuantity());
    }

    /**
     * Test untuk memastikan bahwa menghapus item mengurangi jumlah item dalam keranjang.
     */
    public function testRemoveItemDecreasesItemCount()
    {
        $cart = new ShoppingCart();
        $cart->addItem('Apel', 10000, 2);
        $cart->addItem('Pisang', 5000, 3);

        $cart->removeItem('Pisang');

        // Memastikan jumlah item sekarang adalah 1.
        $this->assertCount(1, $cart->getItems());

        // Memastikan keranjang tidak kosong.
        $this->assertNotEmpty($cart->getItems());

        // Memastikan bahwa ukuran array item sama dengan array yang berisi 'Apel'.
        $this->assertSameSize(['Apel'], array_keys($cart->getItems()));

        $cart->removeItem('Apel');

        // Memastikan keranjang sekarang kosong.
        $this->assertEmpty($cart->getItems());
    }

    /**
     * Test untuk memastikan bahwa dua keranjang dengan jumlah item yang sama memiliki ukuran yang sama.
     */
    public function testSameSizeBetweenCarts()
    {
        $cart1 = new ShoppingCart();
        $cart1->addItem('Apel', 10000, 2);
        $cart1->addItem('Pisang', 5000, 3);

        $cart2 = new ShoppingCart();
        $cart2->addItem('Jeruk', 8000, 1);
        $cart2->addItem('Mangga', 12000, 4);

        // Memastikan kedua keranjang memiliki jumlah item yang sama.
        $this->assertSameSize($cart1->getItems(), $cart2->getItems());
    }

    /**
     * Test untuk memastikan keranjang baru kosong.
     */
    public function testEmptyCart()
    {
        $cart = new ShoppingCart();

        // Memastikan keranjang baru benar-benar kosong.
        $this->assertEmpty($cart->getItems());
    }

    /**
     * Test untuk perbandingan harga total.
     */
    public function testTotalPriceComparisons()
    {
        $cart = new ShoppingCart();
        $cart->addItem('Laptop', 15000000, 1);
        $cart->addItem('Mouse', 200000, 2);

        // Memastikan total harga lebih besar dari 15 juta.
        $this->assertGreaterThan(15000000, $cart->getTotalPrice());

        // Memastikan total harga kurang dari atau sama dengan 16 juta.
        $this->assertLessThanOrEqual(16000000, $cart->getTotalPrice());

        // Memastikan total harga sama dengan 15.400.000.
        $this->assertEquals(15400000, $cart->getTotalPrice());
    }

    /**
     * Menguji total kuantitas item dalam keranjang belanja.
     *
     * Test ini menambahkan item yang sama dua kali ke keranjang belanja dan memeriksa apakah total kuantitas
     * dihitung dengan benar. Item 'NuggetGedaGedi' ditambahkan dengan kuantitas 2 setiap kali,
     * sehingga total kuantitas seharusnya 4.
     *
     * @return void
     */
    public function testAddItemWithZeroQuantityThrowsException()
    {
        $this->cart = new ShoppingCart();

        // Menguji bahwa menambahkan item dengan kuantitas 0 menghasilkan pengecualian.
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Quantity must be greater than 0.');
        $this->cart->addItem('NuggetGedaGedi', 10000, 0);
    }

    /**
     * Kasus uji untuk memverifikasi bahwa menambahkan item yang sama dengan kuantitas berbeda
     * menghasilkan total kuantitas yang benar dalam keranjang belanja.
     *
     * Test ini membuat instance baru dari ShoppingCart dan menambahkan dua item dengan nama yang sama
     * tetapi kuantitas berbeda. Kemudian memeriksa bahwa total kuantitas item dalam keranjang
     * dihitung dengan benar.
     *
     * @return void
     */
    public function testSameItemsHaveSameTotalQuantity()
    {
        $cart = new ShoppingCart();
        $cart->addItem('Apel', 10000, 2);
        $cart->addItem('Apel', 15000, 3);

        // Memastikan total quantity adalah 5.
        $this->assertEquals(5, $cart->getTotalQuantity());
    }
}
