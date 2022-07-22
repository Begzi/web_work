<?php

namespace app\helpers;

class TextHelper {
    public static function drawTreeRaw($items, $titleAttribute = 'title', $liAttributesFunction = '', $liHtmlFunction = '') {
        $depth = -1;
        foreach($items as $item) {
            if ($depth < $item->depth) {
                echo '<ul>';
                $depth = $item->depth;
            } elseif($depth == $item->depth) {
                echo '</li>';
            } elseif($depth > $item->depth) {
                echo str_repeat('</li></ul>', $depth - $item->depth);
                echo '</li>';
                $depth = $item->depth;
            }

            $attr = '';
            $html = $item->$titleAttribute;

            if ($liAttributesFunction !== '') $attr = ' ' . $liAttributesFunction($item);
            if ($liHtmlFunction !== '') $html = $liHtmlFunction($item);

            echo '<li'.$attr.'>'.$html;
        }
        echo str_repeat('</li></ul>', $depth + 1);
    }

    public static function translit($str)
    {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }

    public static function price($price) {
        return number_format($price, 0, '.', ' ');
    }

    public static function getNumEnding($number, $endingArray) {
        $number = $number % 100;
        if ($number >= 11 && $number <= 19) {
            $ending = $endingArray[2];
        } else {
            $i = $number % 10;
            switch ($i) {
                case (1): $ending = $endingArray[0]; break;
                case (2): case (3): case (4): $ending = $endingArray[1]; break;
                default: $ending=$endingArray[2];
            }
        }
        return $ending;
    }

    public static function tel($phone) {
        return preg_replace('/[^0-9]+/', '', $phone);
    }

    public static function textBR($text)
    {
        return str_replace("\r\n", '<br />', $text);
    }

    public static function checkSpam($model, $fields){
        foreach($fields as $field) {
            if (strpos($model->{$field}, '/') !== false) return true;
            if ($model->{$field} != strip_tags($model->{$field})) return true;
            if (preg_match('/(\.\s?ru|www\s?\.|http:|\.\s?com|https:)/i', $model->{$field})) return true;
            if (strpos($model->{$field}, '@') !== false) return true;
        }
        return false;
    }
}
