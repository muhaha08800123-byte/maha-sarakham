<?php
/**
 * Maha Sarakham Travel Guide - Helper Functions
 */

if (!function_exists('e')) {
    /**
     * Escape HTML output to prevent XSS attacks
     */
    function e($string) {
        return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('format_time_range')) {
    /**
     * Format opening and closing times
     */
    function format_time_range($open, $close, $is_24_hours) {
        if ($is_24_hours) {
            return 'เปิด 24 ชั่วโมง';
        }
        if (empty($open) || empty($close)) {
            return 'ยังไม่มีข้อมูลยืนยัน';
        }
        return date('H:i', strtotime($open)) . ' - ' . date('H:i', strtotime($close)) . ' น.';
    }
}

if (!function_exists('get_image_url')) {
    /**
     * Return safe image path or placeholder if image is missing
     */
    function get_image_url($path) {
        if (!empty($path)) {
            // Check direct relative path
            if (file_exists(__DIR__ . '/../' . $path)) {
                return $path;
            }

            // Fallback map by keyword/number to ensure reliable display
            static $fallback_map = [
                '1.' => 'assets/images/attractions/city-pillar.jpg',
                '2.' => 'assets/images/attractions/phra-borommathat-na-dun.jpg',
                '3.' => 'assets/images/attractions/wat-pa-wang-nam-yen.jpg',
                '4.' => 'assets/images/attractions/wat-nong-hu-ling.jpg',
                '5.' => 'assets/images/attractions/wat-phuttha-mongkhon.jpg',
                '6.' => 'assets/images/attractions/wat-suwannawat.jpg',
                '7.' => 'assets/images/attractions/wat-pa-wang-loeng.jpg',
                '8.' => 'assets/images/attractions/phra-that-in-plaeng.jpg',
                '9.' => 'assets/images/attractions/kae-dam-bridge.jpg',
                '10.' => 'assets/images/attractions/kaeng-loeng-chan.jpg',
                '11.' => 'assets/images/attractions/kosampi-park.jpg',
                '12.' => 'assets/images/attractions/ku-santarat.jpg',
                '13.' => 'assets/images/attractions/ku-mahathat.jpg',
                '14.' => 'assets/images/attractions/isan-museum.jpg',
                '15.' => 'assets/images/attractions/sadu-isan.jpg',
            ];
            foreach ($fallback_map as $key => $target) {
                if (strpos($path, $key) !== false && file_exists(__DIR__ . '/../' . $target)) {
                    return $target;
                }
            }
        }
        return 'assets/images/placeholder.svg';
    }
}
?>
