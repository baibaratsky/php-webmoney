WebMoney API PHP Library
========================

XML-interfaces supported
------------------------
- [X8](http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X8): retrieving information about purse ownership, searching for system user by his/her identifier or purse
- [X11](http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X11): retrieving information from client’s passport by WM-identifier
- [X17](http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X17): operations with arbitration contracts
- [X18](http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X18): getting transaction details via merchant.webmoney
- [X19](http://wiki.wmtransfer.com/projects/webmoney/wiki/Interface_X19): verifying personal information for the owner of a WM identifier

[Capitaller API](http://www.capitaller.ru/ws/DoPayment.asmx) is also supported.

Requirements
------------
The library requires PHP 5.3 compiled with [cURL extension](http://www.php.net/manual/en/book.curl.php) (but you can override cURL dependencies).

To use signing with the WM Kepper Classic keys you have to compile PHP with [BCMath](http://www.php.net/manual/en/book.bc.php) and [GMP](http://www.php.net/manual/en/book.gmp.php) support.

To use Capitaller API you have to compile PHP with [SOAP](http://www.php.net/manual/en/book.soap.php) support.
