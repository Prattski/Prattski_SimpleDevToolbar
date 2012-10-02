Prattski_SimpleDevToolbar
=========================

Only tested on Magento CE 1.7.

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

<img src="http://prattski.com/wp-content/uploads/2012/09/devtoolbar-frontend1.png" alt="" title="Magento Developer Toolbar - Frontend" />

<img src="http://prattski.com/wp-content/uploads/2012/09/devtoolbar-admin1.png" alt="" title="Magento Developer Toolbar - Admin" />


## Installation

### Downloading ###

If you want to download the files and install yourself, you can go to the "Downloads"
link in this repository and download the files manually.  The folder structure in the
repository directly mirrors where the files should go in Magento.

### Modman ###

If you have installed Modman on your machine, downloading and installing is very easy.
In your terminal, go to your Magento root directory and do the following:
```
$ modman init            # This is only done once in the application root
$ modman clone https://github.com/Prattski/Prattski_SimpleDevToolbar.git
```

If you don't have/use Modman and you want to check it out, 
<a href="https://github.com/colinmollenhour">visit the modman github page</a>.