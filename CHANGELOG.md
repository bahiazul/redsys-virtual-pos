# Changelog

## Version 0.5.0 (5 April 2021)

-   Transfer package to its new owner

## Version 0.4.8 (30 March 2021)

-   Hotfix. Remove envelope fields from Response

## Version 0.4.7 (25 March 2021)

-   Update PHP requirements (>=5.4.0 <8.0)
-   Switch to a more permissive license (BSD-3 -> MIT)
-   Update Response fields (fixes sample)
-   Add undocumented field `DS_Card_Number`
-   Fix exception invocation
-   Fix function signature
-   Fix typo \*

\* This introduces minor API changes. Rename (`/Envelop/Envelope/`) in `WebRequest::setEnvelopParams()`, `WebRequest::getEnvelopParams()` and `WebResponse::getEnvelopParams()`.

## Version 0.4.6 (24 March 2021)

-   Update test suite.

## Version 0.4.5 (24 March 2021)

-   Add response field: `Ds_ProcessedPayMethod`.

## Version 0.4.4 (11 March 2021)

-   Replace deprecated `mcrypt_encrypt()` by `openssl_encrypt()`.

## Version 0.4.3 (11 March 2021)

-   Fix class name casing for [PSR-4](https://www.php-fig.org/psr/psr-4/) compliance.

## Version 0.4.2 (7 April 2020)

-   Normalize documentation filenames

## Version 0.4.1 (7 April 2020)

-   Hotfix

## Version 0.4.0 (6 April 2020)

-   Add request fields: `Ds_Merchant_Acquirer_Identifier`, `Ds_Merchant_Cof_Ini`, `Ds_Merchant_Cof_Txnid`, `Ds_Merchant_Cof_Type`, `Ds_Merchant_Customer_Mail`, `Ds_Merchant_Customer_Mobile`, `Ds_Merchant_Customer_Sms_Text`, `Ds_Merchant_Dcc`, `Ds_Merchant_DirectPayment`, `Ds_Merchant_Emv3ds`, `Ds_Merchant_Excep_Sca`, `Ds_Merchant_Group`, `Ds_Merchant_Identifier`, `Ds_Merchant_IdOper`, `Ds_Merchant_MatchingData`, `Ds_Merchant_MerchantDescriptor`, `Ds_Merchant_MpiExternal`, `Ds_Merchant_P2f_ExpiryDate`, `Ds_Merchant_P2f_XmlData`, `Ds_Merchant_PayMethods`, `Ds_Merchant_PersoCode`, `Ds_Merchant_ShippingAddressPyp`, `Ds_Merchant_Tax_Reference`, `Ds_Merchant_Terminal`, `Ds_Merchant_Titular`, `Ds_Merchant_TransactionDate`, `Ds_Merchant_TransactionType`, `Ds_Merchant_UrlKo`, `Ds_Merchant_UrlOk`, `Ds_Merchant_XPayData`, `Ds_Merchant_XPayOrigen` and `Ds_Merchant_XPayType`
-   Add response fields: `Codigo`, `Ds_Merchant_Cof_Txnid`, `Ds_DCC`, `Ds_Merchant_Identifier` and `Ds_UrlPago2Fases`
-   Update field name cases
-   Add documentation

## Version 0.3.4 (19 April 2017)

-   Add undocumented field `DS_Card_Brand`

## Version 0.3.3 (26 April 2016)

-   Add undocumented field `DS_MerchantPartialPayment` (only used by CaixaBank’s Cyberpac)
-   Add documentation for CaixaBank’s Cyberpac
-   Update Redsys’ official documentation

## Version 0.3.2 (1 November 2015)

-   Fix field names on params array indices
-   Fix missing case-sensitive renames (OSX, Y U NO CS?)
-   Refactoring of the Sample

## Version 0.3.1 (30 October 2015)

-   Minor fixes in sample

## Version 0.3.0 (30 October 2015)

-   Add support new cryptographic algorithm (SHA-2, HMAC_SHA256_V1) for message signing
-   Update for the new Redsys API
-   General overhaul and simplification
-   Improve sample with request/response support, logging and detailed reporting
-   Update documentation (Redsys and Banco Sabadell)

## Version 0.2.0 (29 October 2014)

-   Handle unknown or empty Error and Response codes gracefully

## Version 0.1.3 (27 October 2014)

-   Translate response type descriptions and error messages to Spanish for consistency
-   Improve naming of response types
-   `Response::getType()` now returns the type name instead of its description
-   Rename `AbstractMessage::getFieldClassName()` to `AbstractMessage::resolveFieldClassName()`
-   Lowercase field key names in order to ease integration with databases
-   Add method `Field\Response::getTypeDescription()`
-   Other minor fixes and improvements

## Version 0.1.2 (21 October 2014)

-   Rename the response fields to match Redsys's Online Response ones
-   Add Error Code field to the Response
-   Add source implementation docs

## Version 0.1.0 (20 October 2014)

Initial (stealth) release
