<?php

/*
 * Copyright © 2018 CrazyCat, Inc. All rights reserved.
 * See COPYRIGHT.txt for license details.
 */

namespace CrazyCat\Core\Block\Backend;

use CrazyCat\Core\Block\Form\Renderer\Select as SelectRenderer;
use CrazyCat\Core\Block\Form\Renderer\Text as TextRenderer;
use CrazyCat\Framework\App\ObjectManager;
use CrazyCat\Framework\App\Session\Backend as Session;
use CrazyCat\Framework\Utility\StaticVariable;

/**
 * @category CrazyCat
 * @package CrazyCat\Core
 * @author Bruce Z <152416319@qq.com>
 * @link http://crazy-cat.co
 */
abstract class AbstractGrid extends \CrazyCat\Framework\App\Module\Block\AbstractBlock {

    const BOOKMARK_FILTER = 'filter';
    const BOOKMARK_SORTING = 'sorting';

    /**
     * field types
     */
    const FIELD_TYPE_SELECT = 'select';
    const FIELD_TYPE_TEXT = 'text';

    protected $template = 'CrazyCat\Core::grid';

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \CrazyCat\Framework\App\Session\Backend
     */
    protected $session;

    /**
     * @var array
     */
    protected $bookmarks;

    public function __construct( Session $session, ObjectManager $objectManager, Context $context, array $data = array() )
    {
        parent::__construct( $context, $data );

        $this->objectManager = $objectManager;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getBookmarks()
    {
        if ( $this->bookmarks === null ) {
            $this->bookmarks = $this->session->getGridBookmarks( static::BOOKMARK_KEY ) ?:
                    [ self::BOOKMARK_FILTER => [], self::BOOKMARK_SORTING => [] ];
        }
        return $this->bookmarks;
    }

    /**
     * @param array $bookmarks
     * @return $this
     */
    public function setBookmarks( array $bookmarks )
    {
        $this->session->setGridBookmarks( static::BOOKMARK_KEY, $bookmarks );
        return $this;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->getBookmarks()[self::BOOKMARK_FILTER];
    }

    /**
     * @return array
     */
    public function getSortings()
    {
        return $this->getBookmarks()[self::BOOKMARK_SORTING];
    }

    /**
     * @param string $fieldName
     * @return array|null
     */
    public function getSorting( $fieldName )
    {
        foreach ( $this->getBookmarks()[self::BOOKMARK_SORTING] as $sorting ) {
            if ( $sorting['field'] == $fieldName ) {
                return $sorting;
            }
        }
        return null;
    }

    /**
     * @param array $field
     * @param mixed $value
     * @return string
     */
    public function renderFilter( $field )
    {
        if ( isset( $field['ids'] ) ) {
            return '<input type="checkbox" class="input-ids" data-selector=".input-ids" />';
        }
        else if ( isset( $field['actions'] ) ) {
            return '&nbsp;';
        }

        switch ( $field['filter']['type'] ) {

            case self::FIELD_TYPE_SELECT :
                $renderer = $this->objectManager->create( SelectRenderer::class );
                $options = isset( $field['filter']['options'] ) ? $field['filter']['options'] :
                        ( isset( $field['filter']['source'] ) ? $this->objectManager->create( $field['filter']['source'] )->toOptionArray() : [] );
                array_unshift( $options, [ 'label' => '', 'value' => StaticVariable::NO_SELECTION ] );
                $renderer->setData( 'options', $options );
                break;

            case self::FIELD_TYPE_TEXT :
                $renderer = $this->objectManager->create( TextRenderer::class );
                break;
        }

        $filters = $this->getFilters();
        $value = isset( $filters[$field['name']] ) ? $filters[$field['name']] : null;

        return $renderer->addData( [ 'field' => $field, 'value' => $value ] )
                        ->setFieldNamePrefix( 'filter' )
                        ->setClasses( 'filter-' . $field['name'] )
                        ->setParams( [ 'data-selector' => '.filter-' . $field['name'] ] )
                        ->toHtml();
    }

    /**
     * Return array structure is like:
     * [
     *     [
     *         'name' => string,
     *         'label' => string,
     *         'sort' => boolean,
     *         'filter' => [
     *             'type' => string,
     *             'options' => array,
     *             'condition' => string
     *         ]
     *     ]
     * ]
     *
     * @return array
     */
    abstract public function getFields();

    /**
     * @return string
     */
    abstract public function getSourceUrl();
}
