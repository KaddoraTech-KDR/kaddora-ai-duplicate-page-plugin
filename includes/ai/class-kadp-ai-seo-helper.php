<?php
if (!defined("ABSPATH")) exit;

class KADP_AI_SEO_Helper
{
  public function meta_description($content)
  {
    $ai = new KADP_AI_Manager();
    return $ai->rewrite_content($content);
  }
}
