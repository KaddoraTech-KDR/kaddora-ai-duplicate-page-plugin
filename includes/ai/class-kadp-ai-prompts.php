<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_AI_Prompts
{
  // rewrite
  public static function rewrite($content)
  {
    return "Rewrite this content in a professional SEO-friendly tone:\n\n" . $content;
  }

  // title
  public static function title($content)
  {
    return "Generate a catchy SEO optimized title for:\n\n" . $content;
  }
}
