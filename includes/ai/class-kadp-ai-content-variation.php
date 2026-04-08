<?php
if (!defined("ABSPATH")) exit;

class KADP_AI_Content_Variation
{
  public function generate($content)
  {
    return $content . ' (variation)';
  }
}
