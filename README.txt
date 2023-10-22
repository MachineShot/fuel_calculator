Fuel calculator
===========

Fuel calculator for Drupal.

Instructions
------------

Unpack in the *modules* folder and enable in `/admin/modules`.

Then, visit `/admin/config/development/fuel_calculator` and enter
your own set of default values (or use the initial values).

Visit `www.example.com/fuel_calculator/{travelled}/{consumption}/{price}` where:
- *travelled* is the distance travelled in km
- *consumption* is the fuel consumption in L/100km
- *price* is the price per Liter in EUR

Or visit 'www.example.com/fuel_calculator'

Or use as an embed block.

If you need, there's also a specific *calculate fuel* permission.
