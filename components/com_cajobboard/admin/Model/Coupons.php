<?php
/*
Hikashop has coupons, so does Akeeba Subs

Hikashop API:

https://www.hikashop.com/support/documentation/62-hikashop-developer-documentation.html#cart

 extends akeeba subs coupons, uses a hasOne() table in our component for add'l fields?
 this has to be forked like this because Brent wants add'l fields in the coupons, specs pg. 2:

9) Coupon options.  Options for each coupon:
  a. Name of coupon
  b. Number of uses per member
  c. Discount
  d. Items the coupon can be applied to
  e. Description
  f. Published yes/no

k. AwoCoupon has these features:

    • Product(s) specific discounts
    • Customer(s) specific discounts
    • The ability to only trigger coupons if a minimum cart total is reached
    • Ability to set expiration dates for coupons
    • Restrict the number of times a coupon can be used by any given user
    • Easy management of all coupons
    • Gift Certificate style coupons
*/
