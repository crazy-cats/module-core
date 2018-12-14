<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Block\Backend\Stage;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
class Edit extends \CrazyCat\Framework\App\Module\Block\Backend\AbstractEdit {

    /**
     * @return array
     */
    public function getFields()
    {
        return [
                [ 'name' => 'id', 'label' => __( 'ID' ), 'type' => 'hidden' ],
                [ 'name' => 'name', 'label' => __( 'Stage Name' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                [ 'name' => 'code', 'label' => __( 'Code' ), 'type' => 'text', 'validation' => [ 'required' => true ] ],
                [ 'name' => 'enabled', 'label' => __( 'Enabled' ), 'type' => 'select', 'options' => [ [ 'value' => '1', 'label' => __( 'Yes' ) ], [ 'value' => '0', 'label' => __( 'No' ) ] ] ]
        ];
    }

    /**
     * @return string
     */
    public function getActionUrl()
    {
        return getUrl( 'system/stage/save' );
    }

}