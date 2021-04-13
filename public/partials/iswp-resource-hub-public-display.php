<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       jmlunalopez.com/wordpress-plugins
 * @since      1.0.0
 *
 * @package    Iswp_Resource_Hub
 * @subpackage Iswp_Resource_Hub/public/partials
 */

// Variable is passed through extract, leaving this so highlighter won't complain.
if (!isset($hub_id)) {
    $hub_id = "";
}
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="reshub" id="reshub_<?=$hub_id?>">
    <div class="reshub_toolbar">
        <div class="reshub_year_area">
            <select class="reshub_selector_year reshub_selector"></select>
        </div>
        <div class="reshub_searchbar_area">
            <input class="reshub_searchbar" type="text" value="Filter by Keywords or Title" />
        </div>
    </div>
    <div class="reshub_cards">
        <!-- Card content gets rendered here -->
    </div>
</div>