Magento | Remote Media Downloader
============================
Remote Media Downloader for Magento downloads public files as they are needed. This saves space and time and optimises local development as it ull all required images.

**You should not need to enable this module in production.**

Description
-----------
When developing Drupal sites locally, you often face a choice between broken images and taking the time to copy a snapshot of the remote files directory, which might be several gigabytes large, depending on the site. 

Remote Media Downloader lets you update the database of your local development instance without having to update your files directory. Remote Media Downloader transfers each requested file just in time when it is requested. This is especially useful for large sites with huge numbers of files. 

If you only visit 2 pages and only need 10 remote files to serve those pages, Remote Media Downloader will only transfer those 10 files.

How to use
-------------
Copy the files to appropriate locations on your Magento installation or use **modman**
Then go to System -> Config Media File Storate and set the Remote url

**Warning**
------------

```php
Magento Remote Media Downloader might be slow on the first request of a page. As it will go throught and download any missing images on your locall server.

**DO NOT USE ON PRODUCTION**
```

Compatibility
-------------
- Magento >= 1.4

Support
-------
If you have any issues with this extension, open an issue on GitHub (see URL above)

Contribution
------------
Any contributions are highly appreciated. The best way to contribute code is to open a
[pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Developers
---------
Dimitris Stoikidis  jstoikidis@gmail.com
[@St0iK](https://twitter.com/St0iK)

Jamie Sykes
jamie.sykes@creode.co.uk

Licence
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)
