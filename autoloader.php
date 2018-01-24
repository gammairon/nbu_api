<?php

class GammaAutoloader {

    protected $namespaceMap = array();

    public function addNamespace($namespace, $rootDir){
        if (is_dir($rootDir)){
            $this->namespaceMap[$namespace] = $rootDir;
            return true;
        }
        return false;
    }

    public function register(){
        spl_autoload_register(array($this, 'autoload'));
    }

    protected function autoload($class){

        $pathParts = explode('\\', $class);

        if (is_array($pathParts)){

            $namespace = array_shift($pathParts);

            if (!empty($this->namespaceMap[$namespace])){

                $filePath = $this->namespaceMap[$namespace].'/'.implode('/', $pathParts).'.php';

                if(file_exists($filePath)){
                    require_once $filePath;
                    return true;
                }
                else
                    throw new Exception("File $filePath do not exist", 1);
            }

        }
        return false;
    }

}



$autoloader = new GammaAutoloader();

$path_root = __DIR__;

// Регистрируем пространство имен и запускаем автозагрузку

$autoloader->addNamespace('NBU_API', $path_root);

$autoloader->register();