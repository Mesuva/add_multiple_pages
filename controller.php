<?php

// Author: Ryan Hewitt - http://www.mesuva.com.au
namespace Concrete\Package\AddMultiplePages;
use Package;
use SinglePage;

class Controller extends Package {

    protected $pkgHandle = 'add_multiple_pages';
    protected $appVersionRequired = '5.7.4';
    protected $pkgVersion = '0.9.5';

    public function getPackageDescription() {
        return t("Add multiple pages to your site at a time");
    }

    public function getPackageName() {
        return t("Add Multiple Pages");
    }

    public function install() {
        $pkg = parent::install();

        SinglePage::add('/dashboard/sitemap/add_multiple_pages',$pkg);
    }

}

?>