# Swark

> Ark Payment Gateway for Shopware

<a href="https://travis-ci.org/reconnico/swark"><img src="https://badgen.net/travis/reconnico/swark"></a>
<a href="https://codecov.io/github/reconnico/swark"><img src="https://badgen.net/codecov/c/github/reconnico/swark"></a>
<a href="https://github.com/reconnico/swark"><img src="https://badgen.net/github/last-commit/reconnico/swark"></a>
<a href="https://github.com/reconnico/swark"><img src="https://badgen.net/github/release/reconnico/swark"></a>
<a href="https://github.com/reconnico/swark"><img src="https://badgen.net/github/license/reconnico/swark"></a>

## Description

Swark is a payment gateway that provides the ability to pay with Ark in Shopware.

## Milestone to v1.0.0

When all milestones to version 1.0.0 are finished the plugin will be published in this repository
and will be placed in the offical [Shopware store](http://store.shopware.com/) as free to use plugin.

* [ ] integrate [php-client](https://github.com/ArkEcosystem/php-client) in plugin infrastructure and setup
* [ ] write PHPUnit tests for plugin components
* [ ] first successful automated order process with Ark
* [ ] Provide Exchange rate command to process automated update of rates via cronjob
* [ ] integrate QR-Code for easier payment
* [ ] create backend module to overview Ark related orders with transactions
* [ ] provide translations for at least German (most popular country in Shopware)
* [ ] finalize documentation including installation process

## Documentation

You can find installation instructions and detailed instructions on how to use this plugin at the [dedicated documentation site](https://docs.swark.app).

## Testing

``` bash
$ phpunit
```

## Credits
* [Nico Allers](https://github.com/reconnico)
* [Contributors](../../contributors)
    
## License

[MIT](LICENSE) © Nico Allers

