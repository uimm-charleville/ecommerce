<?php

require_once('model/Product.php');

function homepage()
{   
	$productRepository = new ProductRepository();
	$products = $productRepository->getProducts();

	require('views/homePage.php');
}