<?php
class FormHelper {
    public static function text($key, $attr = '') {
        $value = self::getValue($key);
        return "<input type='text' id='$key' name='$key' value='$value' $attr>";
    }

    public static function password($key, $attr = '') {
        return "<input type='password' id='$key' name='$key' $attr>";
    }

    public static function email($key, $attr = '') {
        $value = self::getValue($key);
        return "<input type='email' id='$key' name='$key' value='$value' $attr>";
    }

    public static function number($key, $attr = '') {
        $value = self::getValue($key);
        return "<input type='number' id='$key' name='$key' value='$value' $attr>";
    }

    public static function textarea($key, $attr = '') {
        $value = self::getValue($key);
        return "<textarea id='$key' name='$key' $attr>$value</textarea>";
    }

    public static function select($key, $items, $default = '- Select One -', $attr = '') {
        $value = self::getValue($key);
        $html = "<select id='$key' name='$key' $attr>";
        
        if ($default !== null) {
            $html .= "<option value=''>$default</option>";
        }
        
        foreach ($items as $id => $text) {
            $selected = $id == $value ? 'selected' : '';
            $html .= "<option value='$id' $selected>$text</option>";
        }
        
        $html .= '</select>';
        return $html;
    }

    public static function radio($key, $items, $br = false) {
        $value = self::getValue($key);
        $html = '<div>';
        
        foreach ($items as $id => $text) {
            $checked = $id == $value ? 'checked' : '';
            $html .= "<label><input type='radio' id='{$key}_$id' name='$key' value='$id' $checked>$text</label>";
            if ($br) {
                $html .= '<br>';
            }
        }
        
        $html .= '</div>';
        return $html;
    }

    public static function checkbox($key, $items, $br = false) {
        $value = self::getValue($key);
        $html = '<div>';
        
        foreach ($items as $id => $text) {
            $checked = in_array($id, (array)$value) ? 'checked' : '';
            $html .= "<label><input type='checkbox' id='{$key}_$id' name='{$key}[]' value='$id' $checked>$text</label>";
            if ($br) {
                $html .= '<br>';
            }
        }
        
        $html .= '</div>';
        return $html;
    }

    public static function file($key, $attr = '') {
        return "<input type='file' id='$key' name='$key' $attr>";
    }

    public static function hidden($key, $value = '') {
        return "<input type='hidden' id='$key' name='$key' value='$value'>";
    }

    public static function submit($value = 'Submit', $attr = '') {
        return "<input type='submit' value='$value' $attr>";
    }

    public static function button($value, $attr = '') {
        return "<button type='button' $attr>$value</button>";
    }

    public static function label($for, $text) {
        return "<label for='$for'>$text</label>";
    }

    public static function error($key) {
        global $_err;
        if (isset($_err[$key])) {
            return "<span class='err'>{$_err[$key]}</span>";
        }
        return '';
    }

    private static function getValue($key) {
        if (isset($_POST[$key])) {
            return SecurityHelper::sanitizeInput($_POST[$key]);
        }
        if (isset($_GET[$key])) {
            return SecurityHelper::sanitizeInput($_GET[$key]);
        }
        return '';
    }
} 