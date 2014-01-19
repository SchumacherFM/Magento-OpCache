Magento-OpCache
===============

OpCache Control Panel for Magento Backend.

Based on: [https://gist.github.com/ck-on/4959032](https://gist.github.com/ck-on/4959032)

![image](https://raw.github.com/SchumacherFM/Magento-OpCache/master/doc/Magento-OpCache-PS1.jpg)

- Recheck Cache
- Reset Cache
- Compile all PHP Files in directories app and lib
- SVG pie charts with live reload



Configuration
-------------

System -> Configuration -> System -> OpCachePanel Settings

Set here the API Key names and values for reseting the cache via cURL or wget with a post request.

POST key=value to: http://host.name/opcachepanel


Developer Usage
---------------

See model SchumacherFM_OpCachePanel_Model_Cache:

```
<?php  Mage::getModel('opcache/cache')->reset(); ?>
```


Todo
----

- Use line charts
- internal refactorings



Installation Instructions
-------------------------
1. Install modman from https://github.com/colinmollenhour/modman
2. Switch to Magento root folder
3. `modman init`
4. `modman clone git://github.com/SchumacherFM/Magento-OpCache.git`

Please read the great composer article from Vinai: [Composer installation](http://magebase.com/magento-tutorials/composer-with-magento/)

About
-----

- Key: SchumacherFM_OpCache
- Current Version: 1.0.0
- [Download tarball](https://github.com/SchumacherFM/Magento-OpCache/tags)
- Donation: [http://www.seashepherd.org/](http://www.seashepherd.org/)

History
-------

#### 1.0.0

- Initial Release


Compatibility
-------------

- Magento >= 1.5
- php >= 5.3.0
- Zend Optimizer / OpCache

There exists the possibility that this extension may work with pre-1.5 Magento versions.

Support / Contribution
----------------------

Report a bug using the issue tracker or send us a pull request.

Instead of forking I can add you as a Collaborator IF you really intend to develop on this module. Just ask :-)

We work with: [A successful Git branching model](http://nvie.com/posts/a-successful-git-branching-model/) and [Semantic Versioning 2.0.0](http://semver.org/)

Licence OSL-3
-------------

Copyright (c) 2013 Cyrill (at) Schumacher dot fm

[Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)

Author
------

[Cyrill Schumacher](https://github.com/SchumacherFM) - [My pgp public key](http://www.schumacher.fm/cyrill.asc)

Made in Sydney, Australia :-)

If you consider a donation please contribute to: [http://www.seashepherd.org/](http://www.seashepherd.org/)
