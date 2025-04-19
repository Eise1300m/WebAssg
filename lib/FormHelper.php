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
            return "<span class='error-message'>{$_err[$key]}</span>";
        }
        return '';
    }

    public static function phone($key, $currentValue = '', $attr = '') {
        $value = self::getValue($key) ?: $currentValue;
        return "<input type='tel' id='$key' name='$key' value='$value' pattern='^(\+?6?01)[0-46-9]-*[0-9]{7,8}$' placeholder='Malaysian format: 0123456789' required $attr>";
    }

    public static function street($key, $currentValue = '', $attr = '') {
        $value = self::getValue($key) ?: $currentValue;
        return "<input type='text' id='$key' name='$key' value='$value' placeholder='Enter your street address' required $attr>";
    }

    public static function city($key, $currentValue = '', $attr = '') {
        $value = self::getValue($key) ?: $currentValue;
        return "<input type='text' id='$key' name='$key' value='$value' placeholder='Enter your city' required $attr>";
    }

    public static function state($key, $currentValue = '', $attr = '') {
        $value = self::getValue($key) ?: $currentValue;
        return "<input type='text' id='$key' name='$key' value='$value' pattern='^[A-Za-z\s]+$' placeholder='Enter state (letters only)' required $attr>";
    }

    public static function postalCode($key, $currentValue = '', $attr = '') {
        $value = self::getValue($key) ?: $currentValue;
        return "<input type='text' id='$key' name='$key' value='$value' pattern='^[0-9]{5}$' placeholder='5-digit postal code' required $attr>";
    }

    public static function profilePicture($inputId = 'profile-pic-input', $previewId = 'profile-pic', $currentPicture = '', $attr = '') {
        $defaultImage = '/WebAssg/upload/icon/UnknownUser.jpg';
        $currentImage = !empty($currentPicture) ? $currentPicture : $defaultImage;
        
        $html = '<div class="profile-avatar">';
        $html .= '<img src="' . htmlspecialchars($currentImage) . '" alt="Profile Picture" id="' . $previewId . '">';
        $html .= '<form method="POST" action="" enctype="multipart/form-data" id="profile-pic-form">';
        $html .= '<input type="file" name="profile_pic" id="' . $inputId . '" style="display: none;" accept="image/jpeg,image/png,image/gif" ' . $attr . '>';
        $html .= '<div class="avatar-buttons">';
        $html .= '<button type="button" class="change-avatar-btn" onclick="document.getElementById(\'' . $inputId . '\').click()">Select Picture</button>';
        $html .= '<button type="submit" class="upload-avatar-btn" id="upload-pic-btn" style="display: none;">Upload Picture</button>';
        $html .= '</div>';
        $html .= '</form>';
        $html .= '</div>';
        
        return $html;
    }

    private static function getValue($key) {
        if (isset($_POST[$key])) {
            return ValidationHelper::sanitizeInput($_POST[$key]);
        }
        if (isset($_GET[$key])) {
            return ValidationHelper::sanitizeInput($_GET[$key]);
        }
        return '';
    }
} 