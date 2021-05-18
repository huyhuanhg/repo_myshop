<?php

namespace app\core;
class Template
{
    private $__content;

    public function run($contentView, $data)
    {
        $this->__content = $contentView;
        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, 'data');
        } else {
            $data = $data;
        }
        $this->printEntities();
        $this->printRaw();
        $this->ifCondition();
        $this->foreachCondition();
        $this->forCondition();
//        return $this->__content;
        eval(" ?> " . $this->__content . " <?php ");
    }

    private function printEntities()
    {
        preg_match_all('/{{(.+?)}}/', $this->__content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $value) {
                $replace = "<?= htmlentities(" . trim($value) . "); ?>";
                $this->__content = str_replace($matches[0][$key], $replace, $this->__content);
            }
        }
    }

    private function printRaw()
    {
        preg_match_all('/{!(.+?)!}/', $this->__content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $value) {
                $replace = "<?= " . trim($value) . "; ?>";
                $this->__content = str_replace($matches[0][$key], $replace, $this->__content);
            }
        }
    }

    private function ifCondition()
    {
        preg_match_all('~@if\s*\((.+?)\)~is', $this->__content, $matches);
        preg_match_all('~@endif~is', $this->__content, $endifMatches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $value) {
                $replaceIf = "<?php if(" . $value . "): ?>";
                $replaceEndif = "<?php endif; ?>";
                $this->__content = str_replace($matches[0][$key], $replaceIf, $this->__content);
                $this->__content = str_replace($endifMatches[0][$key], $replaceEndif, $this->__content);
            }
        }
        preg_match_all('~@elseif\s*\((.+?)\)~is', $this->__content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $value) {
                $replaceElseif = "<?php elseif(" . $value . "): ?>";
                $this->__content = str_replace($matches[0][$key], $replaceElseif, $this->__content);
            }
        }
        $this->__content=str_replace('@else', "<?php else: ?>", $this->__content);
    }
    private function forCondition(){
        preg_match_all('~@for\s*\((.+?)\)~is', $this->__content, $matches);
        preg_match_all('/@endfor/',$this->__content,$endforMatches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $value) {
                $replaceFor = "<?php for(".trim($value)."): ?>";
                $this->__content = str_replace($matches[0][$key], $replaceFor, $this->__content);
                $this->__content = str_replace($endforMatches[0][$key], '<?php endfor; ?>', $this->__content);
            }
        }
    }
    private function foreachCondition(){
        preg_match_all('~@foreach\s*\((.+?)\)~is', $this->__content, $matches);
        preg_match_all('/@endforeach/',$this->__content,$endforeachMatches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $key => $value) {
                $replaceFor = "<?php foreach(".trim($value)."): ?>";
                $this->__content = str_replace($matches[0][$key], $replaceFor, $this->__content);
                $this->__content = str_replace($endforeachMatches[0][$key], '<?php endforeach; ?>', $this->__content);
            }
        }
    }
}
