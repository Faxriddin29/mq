<?php


use app\models\Product;
use app\models\Support;

class InvoiceGenerator
{
    private $clients = [];
    private $products = [];

    public function __construct(Support $clients, Product $products)
    {
        $this->clients = $clients;
        $this->products = $products;
    }

    public function generateInvoice()
    {
        return [];
    }
}
