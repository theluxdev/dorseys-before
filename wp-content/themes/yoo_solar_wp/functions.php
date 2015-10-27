<?php
/**
* @package   yoo_solar
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// load config    
require_once(dirname(__FILE__).'/config.php');
function fixed_dashboard_columns() { ?>
    <style type=”text/css”>
        .postbox-container {
          /* 100% for single column, 50% for two columns, 33% for three columns, 25% for four columns */
          min-width: 100% !important;
        }
        .meta-box-sortables.ui-sortable.empty-container { 
    	  display: none;
        }
    </style>
<?php
}
add_action( ‘admin_head-index.php’, ‘fixed_dashboard_columns’ );
function columns_screen_options() {
    add_screen_option(
        'layout_columns',
        array(
            'max'     => 4, //Max number of columns
            'default' => 2  //Default number of columns
        )
    );
}
add_action( 'admin_head-index.php', 'columns_screen_options' );