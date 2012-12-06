<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'upstream_proxy';
$app['version'] = '1.4.7';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('upstream_proxy_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('upstream_proxy_app_name');
$app['category'] = lang('base_category_network');
$app['subcategory'] = lang('base_subcategory_settings');

/////////////////////////////////////////////////////////////////////////////
// Controller info
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['upstream_proxy']['title'] = lang('upstream_proxy_app_name');

$app['controllers']['upstream_proxy']['wizard_name'] = lang('upstream_proxy_app_name');
$app['controllers']['upstream_proxy']['wizard_description'] = lang('upstream_proxy_wizard_description');
$app['controllers']['upstream_proxy']['inline_help'] = array(
    lang('base_tooltip') => lang('upstream_proxy_inline_help'),
);

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['core_requires'] = array(
    'app-base >= 1:1.4.7',
    'app-network-core',
    'app-events-core',
);

$app['core_directory_manifest'] = array(
    '/var/clearos/events/upstream_proxy' => array(),
);

$app['core_file_manifest'] = array(
    'filewatch-upstream-proxy-event.conf'=> array('target' => '/etc/clearsync.d/filewatch-upstream-proxy-event.conf'),
    'upstream_proxy.conf' => array(
        'target' => '/etc/clearos/upstream_proxy.conf',
        'mode' => '0600',
        'owner' => 'root',
        'group' => 'root',
        'config' => TRUE,
        'config_params' => 'noreplace',
    ),
);
