<?php
/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

/* @var $this \CrazyCat\Core\Block\Template */
if ( empty( $buttons = $this->getData( 'buttons' ) ) ) {
    return;
}
?>
<div class="header-buttons">
    <?php foreach ( $buttons as $name => $button ) : ?>
        <button class="button btn-<?php echo $name ?>"
                data-action="<?php echo htmlEscape( json_encode( $button['action'] ) ) ?>">
            <span><?php echo $button['label'] ?></span>
        </button>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
// <![CDATA[
    require( [ 'utility' ], function( utility ) {
        utility.actButton( {wrapper: '.header-buttons'} );
    } );
// ]]>
</script>