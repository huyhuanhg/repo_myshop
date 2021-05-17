<?php

namespace app\core;
class Helper
{
    public function __construct($dir)
    {
        $this->loadAllHelper($dir);
    }

    private function loadAllHelper($dir)
    {
        $listPath = scandir(__DIR_ROOT__ . '/' . $dir);
        if (!empty($listPath)) {
            foreach ($listPath as $item) {
                if ($item !== '.' && $item !== '..' && file_exists(__DIR_ROOT__ . "/$dir/$item")) {
                    require_once __DIR_ROOT__ . "/$dir/$item";
                }
            }
        }
    }
}
