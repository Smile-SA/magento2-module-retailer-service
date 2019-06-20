## Smile Retailer Service 

This module is a plugin for [RetailerSuite](https://github.com/Smile-SA/elasticsuite-for-retailer).

This module add the ability to add services per Retailer Shop.

### Requirements

The module requires :

- [Retailer](https://github.com/Smile-SA/magento2-module-retailer) > 1.2.5
- [Seller](https://github.com/Smile-SA/magento2-module-seller) > 1.3.*

### How to use

1. Install the module via Composer :

``` composer require smile/module-retailer-service ```

2. Enable it

``` bin/magento module:enable Smile_RetailerService ```

3. Install the module and rebuild the DI cache

``` bin/magento setup:upgrade ```

### How to manage services

Go to magento admin panel

Menu : Sellers > Services