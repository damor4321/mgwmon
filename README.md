MGWMON
======

A Backend Application to manage incident alerts about the maintenance of a corporate mail platform.

Alerts are configured to be sent to user groups under certain conditions. Sendings are made via sms and/or email. 

The monitoring, the alert automatic generation and the alert sending funcionalities are programmed in Perl (under /MTA/opt).

The alerts and users management is done using a web application, which is developed in PHP using Kohana, a MVC framework (under /MTA/www).
