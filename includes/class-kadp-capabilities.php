<?php
if (!defined("ABSPATH")) exit;

class KADP_Capabilities
{
  public function init()
  {
    add_role('kadp_manager', 'KADP Manager', [
      'read' => true,
      'edit_posts' => true
    ]);
  }
}
