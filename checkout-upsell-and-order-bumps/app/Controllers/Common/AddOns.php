<?php
/**
 * UpsellWP
 *
 * @package   checkout-upsell-woocommerce
 * @author    Anantharaj B <anantharaj@flycart.org>
 * @copyright 2024 UpsellWP
 * @license   GPL-3.0-or-later
 * @link      https://upsellwp.com
 */

namespace CUW\App\Controllers\Common;

defined('ABSPATH') || exit;

use CUW\App\Controllers\Admin\Page;
use CUW\App\Controllers\Controller;
use CUW\App\Helpers\Plugin;

class AddOns extends Controller
{
    /**
     * Add-ons list.
     *
     * @var array
     */
    private static $list;

    /**
     * Get add-ons list from the bundled JSON file.
     *
     * @return array
     */
    private static function getAddonsList()
    {
	    $addons = get_transient('cuw_addons_list');
	    if (empty($addons)) {
		    $response = wp_remote_get('https://static.flycart.net/upsellwp/list.json');
		    if (!is_wp_error($response)) {
			    $addons = (array)json_decode(wp_remote_retrieve_body($response), true);
			    set_transient('cuw_addons_list', $addons, 24 * 60 * 60);
		    }
	    }
	    return $addons;
    }

    /**
     * Prepare addons list.
     *
     * @return array
     */
    public static function getList()
    {
        if (isset(self::$list)) {
            return self::$list;
        }

        $available_plugins = array_keys(get_plugins());
        foreach (self::getAddonsList() as $slug => &$addon) {
            $error_message = Plugin::getDependenciesError($addon['requires']);
            $addon['message'] = !empty($error_message) ? $error_message : '';
            $addon['is_activatable'] = empty($error_message);
            $addon['is_installed'] = in_array($addon['plugin_file'], $available_plugins);
            $addon['page_url'] = self::parseAddonUrl($addon['page_url'] ?? '', $slug);
            $addon['settings_url'] = self::parseAddonUrl($addon['settings_url'] ?? '', $slug);

            if (in_array($addon['plugin_file'], Plugin::activePlugins())) {
                $addon['is_active'] = true;
                self::$list['active_addons'][$slug] = $addon;
            } else {
                $addon['is_active'] = false;
                self::$list['available_addons'][$slug] = $addon;
            }
        }
        return self::$list;
    }

    /**
     * Parse add-on URL.
     */
    private static function parseAddonUrl($url, $slug)
    {
        if (empty($url)) {
            return $url;
        }
        $addon_page_url = Page::getUrl(['tab' => 'addons', 'addon' => $slug]);
        return str_replace(['{admin_url}', '{addon_url}'], [admin_url(), $addon_page_url], $url);
    }
}