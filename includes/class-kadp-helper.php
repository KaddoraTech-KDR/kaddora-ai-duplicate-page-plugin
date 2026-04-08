<?php
if (!defined('ABSPATH')) exit;

class KADP_Helper
{
  public static function log($message)
  {
    error_log('[KADP] ' . $message);
  }

  public static function format_date($date)
  {
    return date('Y-m-d H:i', strtotime($date));
  }
}
