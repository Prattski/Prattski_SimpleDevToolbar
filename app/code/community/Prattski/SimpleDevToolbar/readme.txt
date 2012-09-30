/**
 * Prattski - Simple Developer Toolbar
 *
 * @category    Prattski
 * @package     Prattski_SimpleDevToolbar
 * @copyright   Copyright (c) 2012 Prattski (http://prattski.com)
 * @author      Josh Pratt (josh@prattski.com)
 */


This module adds a developer toolbar to the top of the page on both the frontend
and the admin for quick toggling of frequently used developer tools in Magento.
It currently does the following:

* Toggle logging
* Toggle frontend template path hints
* Toggle profiler
* Toggle all cache types
* Flush cache if enabled
* Mark all unread admin notifications as read

You can choose to show/not show the toolbar from the system configuration under
Developer > Prattski Developer Tools.  You can also restrict the viewing of the 
toolbar to specified IP addresses by putting them in the "Restrict Toolbar to
IPs" field.