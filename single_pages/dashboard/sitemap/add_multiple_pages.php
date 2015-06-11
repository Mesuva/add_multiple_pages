<?php defined('C5_EXECUTE') or die("Access Denied.");
$form = $ih = Core::make('helper/form');
$ci = Loader::helper('concrete/ui');
?>

<?php if (isset($pageType) && !$success) { ?>
<form method="post" action="<?=$view->action($pageType->getPageTypeHandle())?>">

    <h4><?php echo t('Step 2 - Configure and create pages'); ?></h4>

    <div class="form-group">
        <label for="page_type"><?php echo t('Page Type'); ?>: </label>
        <p><?php echo $pageType->getPageTypeDisplayName(); ?></p>
    </div>

    <div class="form-group">
        <label for="page_type"><?php echo t('Parent Page'); ?></label>
        <?php $pageSelector = Loader::helper('form/page_selector');
        echo $pageSelector->selectPage('parent_page',null,'ccm_selectSitemapNode');
            ?>
    </div>


    <div class="form-group">
        <label for="page_template"><?php echo t('Page Template'); ?></label>
        <?php echo $form->select('page_template', $pageTemplates)?>
    </div>

    <div class="form-group">
        <label for="pagenames"><?php echo t('Page Names (enter one per line)'); ?></label>
        <?php echo $form->textarea('pagenames', '', array('rows'=>6,'class' => 'span2', 'placeholder'=>t('Page names, one per line')))?>
    </div>


    <?php
    ob_start( );
    $pageType->renderComposerOutputForm(null, $parent);
    $output = ob_get_clean();
    ?>

    <h3><?php echo t('Page Defaults'); ?></h3>

    <div id="defaults" style="display: none">
    <?php echo $output; ?>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">

            <?php echo $ci->button(t('Cancel'), $view->url('/dashboard/sitemap/add_multiple_pages'), 'left'); ?>

            <button class="pull-right btn btn-success" type="submit" ><?php echo t('Create Pages')?></button>
        </div>
    </div>

</form>


<script>
    $(document).ready(function(){
        $("div[data-composer-field='name'],div[data-composer-field='page_template']").parent().remove();
        $("div[data-composer-field='url_slug']").remove();

        $('#defaults').show();

    });
</script>
<?php } else { ?>
<h4><?php echo t('Step 1 - Select Page Type'); ?></h4>

    <ul class="list-group">
        <?php foreach($pageTypes as $key=>$pagetypename) { ?>
        <li  class="list-group-item"><a href="<?php echo $this->url('/dashboard/sitemap/add_multiple_pages', $key);?>"><?php echo $pagetypename; ?></a></li>
        <?php } ?>
    </ul>

<?php } ?>