=== Checkout For Nabil Bank Payment Gateway by Nepal Payments Hub ===
Contributors: nepalpaymentshub, sanzeeb3
Tags: nabil, nabil bank, woocommerce, payments, store
Requires at least: 6.0
Tested up to: 6.5
Requires PHP: 7.0
Stable tag: 1.0.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Adds Nabil Bank Payment Gateway for WooCommerce.

== Description ==

### WOOCOMMERCE NABIL BANK PAYMENT GATEWAY PLUGIN

Accept international payments from Credit Cards (Visa, Mastercard, UnionPay) via your Nabil Bank Merchant.

[Nabil Bank Merchant account](https://nbankhome.nabilbank.com/digital-form/merchant-onboarding) is required to accept payments.


[Setup Documentation](https://sanjeebaryal.com.np/nabil-bank-payment-gateway-for-wordpress-woocommerce/)


**What's next?**

You may also check the [Himalayan Bank Payment Gateway](https://sanjeebaryal.com.np/accept-himalayan-bank-payment-from-your-woocommerce-site/) to provide more options to the customers.

Or, checkout the [free Nepali Payment gateways for WooCommerce](https://nepalpaymentshub.com/free-nepali-payments-gateways-plugins-for-woocommerce/)


== Frequently Asked Questions ==

= How does it work?

Once you install & activate the plugin, the new payment gateway option (Nabil Bank) will be available. You can configure by entering your Nabil Bank Merchant ID and Password in the settings.
Customers will be redirected to Nabil Bank payment page for entering the credit cards details.

= Which currency is supported?

The curreny you're setting up in Nabil Bank Merchant & the currency in WooCommerce should match. Either it's USD or NPR, or any other currency supported by Nabil Bank.

= I get "Error processing checkout. Please try again."

Turn on Debug log from *WooCommerce > Payments > Nabil Bank*. Check the log file in wp-content/uploads/wc-logs/Nabil-bank-{date}-xxx.log. You can see full technical details on what went wrong.

= Payment status is "Processing"

That's fine. "Processing" doesn't mean it's processing payment -- it means it's being processed/fulfilled by the site owner. If the products are marked both 'Virtual' and 'Downloadable', then the orders will automatically go to Complete status. 

[Read More](https://sanjeebaryal.com.np/why-is-my-woocommerce-order-status-always-processing/)


== Changelog ==

= 1.0.0 - xx/xx/2024 =
* Initial Release
