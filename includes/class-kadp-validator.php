<?php
if (!defined("ABSPATH")) exit;

class KADP_Validator
{
  public static function is_valid_post($post_id)
  {
    return get_post($post_id) !== null;
  }

  public static function sanitize_text($text)
  {
    return sanitize_text_field($text);
  }
}
