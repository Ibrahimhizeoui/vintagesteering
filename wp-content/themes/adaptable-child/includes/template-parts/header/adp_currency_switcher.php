<?php namespace LukeRoberts;

// Instantiate Currency class
$currencies = new Currency();

// Localize necessary currency data in javascript
$currencies->localizeCurrency();

// The current currency set
$currentCurrency = $currencies->getCurrentCurrency();

// List currency abbreviations
$availableCurrencies = $currencies->currencyAbbreviations(); ?>

<ul class="currencySwitcher__list" data-currency-switcher>
    <li class="currencySwitcher__item"><span data-current-currency="<?php echo $currentCurrency; ?>"> <?php echo $currentCurrency; ?></span></li>

    <ul class="currencySwitcher__dropdown">
        <?php
        foreach($availableCurrencies as $abbr):
            echo "<li class=\"currencySwitcher__item\"><a data-currency=\"{$abbr}\" href=\"\">{$abbr}</a></li>";
        endforeach;
        ?>
    </ul>

</ul>
