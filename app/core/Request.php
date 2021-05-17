<?php

namespace app\core;
class Request
{
    private $__rules;
    private $__message;
    private $__errors;
    public $__dataField;

    public function __construct()
    {
        $this->__dataField = $this->getFields();
    }

    public function isGet()
    {
        if (Router::getRequestMethod() === 'GET') {
            return true;
        }
        return false;
    }

    public function isPost()
    {
        if (Router::getRequestMethod() === 'POST') {
            return true;
        }
        return false;
    }

    private function getFields()
    {
        $dataFields = [];
        if ($this->isGet()) {
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        if ($this->isPost()) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFields[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }
        return $dataFields;
    }

    public function rules($rules = [])
    {
        $this->__rules = array_filter($rules);
    }

    public function message($message = [])
    {
        $this->__message = $message;
    }

    public function validate()
    {
        $check = true;
        if (!empty($this->__rules)) {
            foreach ($this->__rules as $fieldName => $ruleItem) {
                $rulesArr = explode('|', $ruleItem);
                foreach ($rulesArr as $rule) {
                    $ruleName = null;
                    $ruleValue = null;
                    $ruleArr = explode(':', $rule,2);
                    $ruleName = reset($ruleArr);
                    if (count($ruleArr) > 1) {
                        $ruleValue = end($ruleArr);
                    }
                    // chua goi duoc callback vi khoi tao controller la da xay ra middleware
                    if (preg_match('~^callback_(.+)~is', $ruleName, $callbackArr)) {
                        if (!empty($callbackArr[1])) {
                            $callback = $callbackArr[1];
                            $controller = Registry::getIntance()->CtlObj;
                            die($controller);
                            if (method_exists($controller, $callback)) {
                                $checkCallback = call_user_func_array([$controller, $callback], [trim($this->__dataField[$fieldName])]);
                            }
                            if (!$checkCallback) {
                                if (!isset($this->__errors[$fieldName])) {
                                    $this->__errors[$fieldName] = $this->__message["$fieldName.$ruleName"];
                                }
                                $check = false;
                            }
                        }
                    } else {

                        if (method_exists($this, $ruleName)) {
                            if (!$this->$ruleName($this->__dataField[$fieldName], $ruleValue)) {
                                if (!isset($this->__errors[$fieldName])) {
                                    $this->__errors[$fieldName] = $this->__message["$fieldName.$ruleName"];
                                }
                                $check = false;
                            }
                        }
                    }
                }
            }
        }
        $sessionKey = Session::isInvalid();
        Session::flash($sessionKey . "_errors", $this->__errors);
        Session::flash($sessionKey . "_current", $this->__dataField);
        return $check;
    }

    public function errors($fieldName = '')
    {
        if (!empty($this->__errors)) {
            if (!empty($fieldName)) {
                return $this->__errors[$fieldName];
            }
            return $this->__errors;
        }
        return false;
    }

    private function required($rule, $param = true)
    {
        if (empty(trim($rule)) && trim($rule) != '0') {
            return false;
        }
        return true;
    }

    private function min($rule, $param)
    {
        if (strlen($rule) < $param) {
            return false;
        }
        return true;
    }

    private function equal($rule, $param)
    {
        if ($rule !== $this->__dataField[$param]) {
            return false;
        }
        return true;
    }

    private function email($rule, $param = true)
    {
        if (!filter_var($rule, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    private function date($rule, $param = true)
    {
        if (preg_match("~^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$~is", $rule)) {
            $dateArr = explode('-', $rule);
            list($year, $month, $day) = $dateArr;
            $month_31_day = ['01', '03', '05', '07', '08', '10', '12'];
            $month_30_day = ['04', '06', '09', '11'];
            if ($month < 1 || $month > 12) {
                return false;
            }
            if ($day < 1 || $day > 31) {
                return false;
            }
            if ($day == 31 && !in_array($month, $month_31_day)) {
                return false;
            }
            if ($day == 30 && !in_array($month, $month_30_day)) {
                return false;
            }
            if ($month == 2 && (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0)) {
                if ($day > 29) {
                    return false;
                }
            } else {
                if ($month == 2 && $day > 28) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    private function number($rule, $param = true)
    {
        if (preg_match("~[\d+]{10}~is", $rule)) {
            return true;
        } else {
            return false;
        }
    }

    private function minword($rule, $param = 1)
    {
        if (strpos(trim($rule), ' ')) {
            return true;
        }
        return false;
    }

    private function unique($rule, $params)
    {
        $paramsArr= explode(':',$params);
        $tableName = reset($paramsArr);
        $fieldName = end($paramsArr);
        $unique = Database::table($tableName)->where($fieldName,'=', $rule)->get()->rowCount();
        if ($unique === 1){
            return false;
        }
        return true;
    }
}
