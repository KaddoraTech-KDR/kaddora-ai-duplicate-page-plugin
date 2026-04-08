<?php
if (!defined("ABSPATH")) exit;

class KADP_AI_Title_Rewriter
{
  public function rewrite($content)
  {
    $ai = new KADP_AI_Manager();
    return $ai->generate_title($content);
  }
}
