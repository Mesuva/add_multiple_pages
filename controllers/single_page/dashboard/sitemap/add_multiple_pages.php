<?php

namespace Concrete\Package\AddMultiplePages\Controller\SinglePage\Dashboard\Sitemap;

use \Concrete\Core\Page\Controller\DashboardPageController;
use Database;
use Config;
use File;
use PageTemplate;
use PageType;

defined('C5_EXECUTE') or die("Access Denied.");
class AddMultiplePages extends DashboardPageController
{

    public function view($pagetypehandle = '') {

        if ($pagetypehandle) {
            //$pageTemplates = PageTemplate::getList();

            $pageType = \PageType::getByHandle($pagetypehandle);
            $pageTemplates = $pageType->getPageTypePageTemplateObjects();


            $pageTemplatesSelect = array();

            foreach($pageTemplates as $pt) {
                $pageTemplatesSelect[$pt->getPageTemplateID()] = $pt->getPageTemplateDisplayName();
            }

            $this->set('pageTemplates', $pageTemplatesSelect);
            $this->set('pageType', $pageType);

        }


        if ($this->isPost()) {

            $error = false;

            if ($this->post('parent_page') <= 0) {
                $this->error->add(t('A parent page must be selected'));
                $error = true;
            }

            if ($this->post('page_template') <= 0) {
                $this->error->add(t('A page template must be selected'));
                $error = true;
            }

            if (!trim($this->post('pagenames'))) {
                $this->error->add(t('At least one page name must be entered'));
                $error = true;
            }

            if (!$error) {

                $numpages = 0;

                $pagenames = explode("\n", trim($this->post('pagenames')));
                $parentPage = \Page::getByID($this->post('parent_page'));
                $pageType = \PageType::getByID($this->post('ptID'));
                $pageTemplate = \PageTemplate::getByID($this->post('page_template'));

                if (is_object($parentPage) && is_object($pageType) && is_object($pageTemplate)) {
                    foreach ($pagenames as $pagename) {
                        $pagename = trim($pagename);


                        $entry = $parentPage->add($pageType, array(
                            'cName' => $pagename
                        ), $pageTemplate);

                        $pageType->savePageTypeComposerForm($entry);
                        $entry->updateCollectionName($pagename);
                        $numpages++;
                    }
                }

                $this->set('message', $numpages . ' ' . t("Pages created"));
                $this->set('success', true);
            }
        }

        $typeList = PageType::getList();
        $pageTypesSelect = array();

        foreach($typeList as $_pagetype) {
            $pageTypesSelect[$_pagetype->getPageTypeHandle()] = $_pagetype->getPageTypeDisplayName();
        }

        $this->set('pageTypes', $pageTypesSelect);

    }



}
?>
