<?php

namespace Modules\WidgetManager\Service;

use APP;


class CWidgetManager {

    protected $widgets = [];

    public function register(string $formClass): void {
        $this->widgets[$formClass::UNIQUEID] = $formClass;
    }

    public function getRegisteredWidgets(): array {
        return $this->widgets;
    }

    public function getJavascriptClasses(): array {
        $classes = [];

        foreach ($this->widgets as $widgetClass) {
            $classes[$widgetClass::UNIQUEID] = $widgetClass::JSCLASS;
        }

        return $classes;
    }

    public function getDefaultDimensions(): array {
        $dimensions = [];

        foreach ($this->widgets as $widgetClass) {
            $dimensions[$widgetClass::UNIQUEID] = defined("$widgetClass::DIMENSIONS") ? $widgetClass::DIMENSIONS : [
                'width' => 12,
                'height' => 10
            ];
        }

        return $dimensions;
    }

    public function getDefaultRfRate(): array {
        $refresh = [];

        foreach ($this->widgets as $widgetClass) {
            $refresh[$widgetClass::UNIQUEID] = defined("$widgetClass::REFRESH_RATE") ? $widgetClass::REFRESH_RATE : 0;
        }

        return $refresh;
    }

    public function includeStylesheet(string $href): void {
        zbx_add_post_js('document.head.appendChild(Object.assign(document.createElement("link"), {rel: "stylesheet", href: "'.$href.'"}));');
    }

    public function getWidgetFormIncludePath(string $type): string {
        if (array_key_exists($type, $this->widgets)) {
            $namespaces = APP::ModuleManager()->getNamespaces();
            $form_class = $this->widgets[$type];

            foreach ($namespaces as $namespace => $paths) {
                if (strpos($form_class, $namespace.'\\') === 0) {
                    $module_dir = reset($paths);

                    return $module_dir.'/views/widget.'.$type.'.form.view.php';
                }
            }
        }

        // Default widgets.
        return APP::getRootDir().'/include/classes/widgets/views/widget.'.$type.'.form.view.php';
    }
}
