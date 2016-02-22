<?php

namespace Gintonic\Makeup\View;

use Cake\Core\App;
use Cake\Utility\Inflector;
use Gintonic\Makeup\View\ViewName;

/**
 * A trait that allows the configuration of default template paths
 *
 * Implementing objects are expected to declare a `$_makeupPaths` property.
 */
trait MakeupViewTrait
{

    protected function _getViewFileName($name = null)
    {
        $subDir = '';
        $templatePath = $this->name . DS;

        if ($this->subDir !== null) {
            $subDir = $this->subDir . DS;
        }
        if ($this->templatePath) {
            $templatePath = $this->templatePath . DS;
        }

        if ($name === null) {
            $name = $this->template;
        }

        list($plugin, $name) = $this->pluginSplit($name);
        $name = str_replace('/', DS, $name);

        if (strpos($name, DS) === false && $name[0] !== '.') {
            $name = $templatePath . $subDir . $this->_inflectViewFileName($name);
        } elseif (strpos($name, DS) !== false) {
            if ($name[0] === DS || $name[1] === ':') {
                $name = trim($name, DS);
            } elseif (!$plugin || $this->templatePath !== $this->name) {
                $name = $templatePath . $subDir . $name;
            } else {
                $name = DS . $subDir . $name;
            }
        }

        foreach ($this->_paths($plugin) as $path) {
            if (file_exists($path . $name . $this->_ext)) {
                return $this->_checkFilePath($path . $name . $this->_ext, $path);
            }
        }
        return parent::_getViewFileName($name);
    }

    protected function _paths($plugin = null, $cached = true)
    {
        if ($cached === true) {
            if ($plugin === null && !empty($this->_paths)) {
                return $this->_paths;
            }
            if ($plugin !== null && isset($this->_pathsForPlugin[$plugin])) {
                return $this->_pathsForPlugin[$plugin];
            }
        }

        $prefix = $this->_prefix();
        if (empty($prefix) || !isset($this->themes) || !isset($this->themes[$prefix])) {
            return parent::_paths($plugin, $cached);
        }

        $folderName = key($this->themes[$prefix]);
        $theme = $this->themes[$prefix][$folderName];
        $makeup = [
            App::path('Template')[0] . $folderName . DS,
            App::path('Template', Inflector::camelize($theme))[0]
        ];

        $paths = parent::_paths($plugin, $cached);
        $paths = array_merge($makeup, $paths);

        if ($plugin !== null) {
            return $this->_pathsForPlugin[$plugin] = $paths;
        }
        return $this->_paths = $paths;
    }

    protected function _prefix()
    {
        $prefix = 'Default';
        if (!empty($this->request->params['prefix'])) {
            $prefixes = array_map(
                'Cake\Utility\Inflector::camelize',
                explode('/', $this->request->params['prefix'])
            );
            $prefix = implode(DS, $prefixes);
        }
        return $prefix;
    }
}
