<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'transmission';
$app['version'] = '1.0.0';
$app['release'] = '1';
$app['vendor'] = 'Tim Burgess';
$app['packager'] = 'Tim Burgess';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('transmission_app_description');
$app['tooltip'] = lang('transmission_app_tooltip');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('transmission_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_file');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['transmission']['title'] = lang('transmission_app_name');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////


$app['core_requires'] = array(
    'transmission >= 2.5',
    'app-base-core >= 1:1.2.6'
);

$app['core_file_manifest'] = array(
    'transmission-daemon.php' => array('target' => '/var/clearos/base/daemon/transmission-daemon.php')
);

$app['delete_dependency'] = array(
    'app-transmission-core',
    'transmission'
);
