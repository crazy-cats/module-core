<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Index\Block\LanguageSwitcher */
$languages = $this->getLanguages();
$currentLangCode = $this->getCurrentLangCode();

$langOpts = [];
foreach ( $languages as $language ) {
    $langOpts[] = [ 'label' => $language['name'], 'value' => $language['code'] ];
}
?>
<div class="block block-language-switcher">
    <div class="block-content">
        <select>
            <?php echo selectOptionsHtml( $langOpts, $currentLangCode ) ?>
        </select>
        <script type="text/javascript">
            // <!CDATA[
            require( [ 'jquery' ], function( $ ) {
                var url = '<?php echo getCurrentUrl(); ?>';
                $( '.block-language-switcher select' ).on( 'change', function(  ) {
                    window.location.href = url + (url.indexOf( '?' ) === -1 ? '?' : '&') + 'lang=' + $( this ).val();
                } );
            } );
            // ]]>
        </script>
    </div>
</div>