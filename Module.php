<?php

namespace Modules\WidgetManager;

use APP, CController;
use Core\CModule as ModuleBase;
use Modules\WidgetManager\Service\CWidgetManager;


if (!APP::Component()->has('widgetmanager')) {
    include_once __DIR__.'/CWidgetConfig.php';
	APP::Component()->register('widgetmanager', new CWidgetManager());
}

class Module extends ModuleBase {

    public function init(): void {
        // Register your widget.
        //APP::Component()->widgetmanager->register(CWidgetFormProblems::class);
    }

    public function onBeforeAction(CController $action): void {
        // Load javascript widget file when dashboard is opened.
        // if ($action->getAction() === 'dashboard.view') {
        //     zbx_add_post_js(file_get_contents(__DIR__.'/public/class.widget.problems.js'));
        // }
    }
}
