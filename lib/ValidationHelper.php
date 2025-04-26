<?php
class ValidationHelper {
    public static function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([self::class, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validatePhone($phone) {
        // Support Malaysian mobile format (01xxxxxxxx) with optional +60/60 prefix
        return preg_match('/^(?:\+?6?01)[0-46-9][0-9]{7,8}$/', $phone);
    }

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function generateToken($length = 32) {
        return bin2hex(random_bytes($length));
    }

    public static function validateFileUpload($file, $type = 'image') {
        $max_size = 5000000; // 5MB
        $allowed_types = [
            'image' => ['image/jpeg', 'image/png', 'image/gif'],
            'document' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']
        ];

        if ($file['size'] > $max_size) {
            return ['success' => false, 'message' => 'File is too large. Maximum size is 5MB.'];
        }

        if (!in_array($file['type'], $allowed_types[$type])) {
            return ['success' => false, 'message' => 'Invalid file type.'];
        }

        return ['success' => true];
    }

    // New method to validate address fields
    public static function validateAddress($street, $city, $state, $postal) {
        $errors = [];
        
        if (empty($street)) {
            $errors['street'] = 'Street address is required';
        }
        
        if (empty($city)) {
            $errors['city'] = 'City is required';
        }
        
        if (empty($state)) {
            $errors['state'] = 'State is required';
        } elseif (!preg_match('/^[A-Za-z\s]+$/', $state)) {
            $errors['state'] = 'State should contain only letters';
        }
        
        if (empty($postal)) {
            $errors['postal'] = 'Postal code is required';
        } elseif (!preg_match('/^[0-9]{5}$/', $postal)) {
            $errors['postal'] = 'Postal code should be 5 digits';
        }
        
        return $errors;
    }

    // Validate state (letters only)
    public static function validateState($state) {
        return preg_match('/^[A-Za-z\s]+$/', $state);
    }

    // Validate street address
    public static function validateStreet($street) {
        if (empty($street)) {
            return false;
        }
        // Street should be at least 5 characters and contain alphanumeric characters
        return (strlen($street) >= 5 && preg_match('/[a-zA-Z0-9]/', $street));
    }
    
    // Validate city (letters and spaces only)
    public static function validateCity($city) {
        if (empty($city)) {
            return false;
        }
        // letters only and at least 2 characters
        return (strlen($city) >= 2 && preg_match('/^[A-Za-z\s]+$/', $city));
    }

    /**
     * 
     * 
     * @param string $postal The postal code to validate
     * @return bool|string True if valid, error message if invalid
     */
    public static function validatePostalCode($postal) {
        $postal = trim($postal);
        
        if (empty($postal)) {
            return "Postal code is required";
        }
        
        if (!preg_match('/^\d{5}$/', $postal)) {
            return "Postal code must be exactly 5 digits";
        }
        
        // Check if postal code is valid for Malaysian states
        if (!self::isValidMalaysianPostalCode($postal)) {
            return "Invalid postal code for Malaysian states";
        }
        
        return true;
    }
    
    /**
     * Check if postal code is valid
     * 
     * @param string $postal The postal code to validate
     * @return bool True if valid, false if invalid
     */
    public static function isValidMalaysianPostalCode($postal) {
        // Malaysian postal code ranges by state
        $postalCodeRanges = [
            // Perlis
            '01000-01999' => 'Perlis',
            
            // Kedah
            '05000-05999' => 'Kedah',
            '06000-06999' => 'Kedah',
            '07000-07999' => 'Kedah',
            '08000-08999' => 'Kedah',
            '09000-09999' => 'Kedah',
            
            // Pulau Pinang
            '10000-14999' => 'Pulau Pinang',
            
            // Perak
            '30000-36999' => 'Perak',
            '39000-39999' => 'Perak',
            
            // Selangor
            '40000-48999' => 'Selangor',
            
            // Kuala Lumpur
            '50000-60999' => 'Kuala Lumpur',
            
            // Putrajaya
            '62000-62999' => 'Putrajaya',
            
            // Negeri Sembilan
            '70000-73999' => 'Negeri Sembilan',
            
            // Melaka
            '75000-78999' => 'Melaka',
            
            // Johor
            '79000-86999' => 'Johor',
            
            // Pahang
            '25000-28999' => 'Pahang',
            '39000-39999' => 'Pahang',
            '49000-49999' => 'Pahang',
            
            // Terengganu
            '20000-24999' => 'Terengganu',
            
            // Kelantan
            '15000-19999' => 'Kelantan',
            
            // Sabah
            '88000-91999' => 'Sabah',
            
            // Sarawak
            '93000-98999' => 'Sarawak',
            
            // Labuan
            '87000-87999' => 'Labuan'
        ];
        
        $postal = (int)$postal;
        
        foreach ($postalCodeRanges as $range => $state) {
            list($min, $max) = explode('-', $range);
            if ($postal >= (int)$min && $postal <= (int)$max) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * @param string $postal The postal code
     * @return string|null The state name or null if not found
     */

    public static function getStateFromPostalCode($postal) {
        
        $postalCodeRanges = [

            // Perlis
            '01000-01999' => 'Perlis',
            
            // Kedah
            '05000-05999' => 'Kedah',
            '06000-06999' => 'Kedah',
            '07000-07999' => 'Kedah',
            '08000-08999' => 'Kedah',
            '09000-09999' => 'Kedah',
            
            // Pulau Pinang
            '10000-14999' => 'Penang',
            
            // Perak
            '30000-36999' => 'Perak',
            '39000-39999' => 'Perak',
            
            // Selangor
            '40000-48999' => 'Selangor',
            
            // Kuala Lumpur
            '50000-60999' => 'Kuala Lumpur',
            
            // Putrajaya
            '62000-62999' => 'Putrajaya',
            
            // Negeri Sembilan
            '70000-73999' => 'Negeri Sembilan',
            
            // Melaka
            '75000-78999' => 'Melaka',
            
            // Johor
            '79000-86999' => 'Johor',
            
            // Pahang
            '25000-28999' => 'Pahang',
            '39000-39999' => 'Pahang',
            '49000-49999' => 'Pahang',
            
            // Terengganu
            '20000-24999' => 'Terengganu',
            
            // Kelantan
            '15000-19999' => 'Kelantan',
            
            // Sabah
            '88000-91999' => 'Sabah',
            
            // Sarawak
            '93000-98999' => 'Sarawak',
            
            // Labuan
            '87000-87999' => 'Labuan'
        ];
        
        $postal = (int)$postal;
        
        foreach ($postalCodeRanges as $range => $state) {
            list($min, $max) = explode('-', $range);
            if ($postal >= (int)$min && $postal <= (int)$max) {
                return $state;
            }
        }
        
        return null;
    }

    // New method to validate profile picture
    public static function validateProfilePicture($file) {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Upload failed: ' . $file['error']];
        }

        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileExt, $allowedExtensions)) {
            return ['success' => false, 'message' => 'Invalid file type! Only JPG, PNG & GIF files are allowed.'];
        }

        if ($fileSize > 5000000) {
            return ['success' => false, 'message' => 'File is too large! Maximum size is 5MB.'];
        }

        return ['success' => true];
    }

} 