<?php

if (!defined('ABSPATH')) {
  exit;
}

class KADP_AI_Manager
{
  private $api_key;

  public function __construct()
  {
    $this->api_key = get_option('kadp_api_key');
  }

  /**
   * REWRITE CONTENT
   */
  public function rewrite_content($content)
  {
    if (!get_option('kadp_enable_ai')) {
      return $content;
    }

    $prompt = KADP_AI_Prompts::rewrite($content);

    return $this->request($prompt, 'rewrite');
  }

  /**
   * GENERATE TITLE
   */
  public function generate_title($content)
  {
    if (!get_option('kadp_enable_ai')) {
      return $content;
    }

    $prompt = KADP_AI_Prompts::title($content);

    return $this->request($prompt, 'title');
  }

  /**
   * API REQUEST
   */
  private function request($prompt, $type = 'rewrite')
  {
    // DEMO MODE (NO API KEY)
    if (empty($this->api_key)) {

      $content = $this->get_random_text();

      $this->log([
        'prompt_type' => $type,
        'response'    => $content,
        'status'      => 'demo'
      ]);

      return $content;
    }

    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', [
      'headers' => [
        'Authorization' => 'Bearer ' . $this->api_key,
        'Content-Type'  => 'application/json',
      ],
      'body' => json_encode([
        'model' => 'gpt-4o-mini',
        'messages' => [
          ['role' => 'user', 'content' => $prompt]
        ],
        'temperature' => 0.7
      ])
    ]);

    // ERROR HANDLING
    if (is_wp_error($response)) {

      $this->log([
        'prompt_type' => $type,
        'response'    => $response->get_error_message(),
        'status'      => 'failed'
      ]);

      return false;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    $content = $body['choices'][0]['message']['content'] ?? '';

    // SUCCESS LOG
    $this->log([
      'prompt_type' => $type,
      'tokens_used' => $body['usage']['total_tokens'] ?? 0,
      'response'    => $content,
      'status'      => 'success'
    ]);

    return $content;
  }

  /**
   * LOG HELPER
   */
  private function log($data)
  {
    $log = new KADP_AI_Log_Model();

    $log->insert([
      'post_id'     => 0,
      'prompt_type' => $data['prompt_type'] ?? '',
      'tokens_used' => $data['tokens_used'] ?? 0,
      'response'    => $data['response'] ?? '',
      'status'      => $data['status'] ?? 'success'
    ]);
  }

  /**
   * DEMO TEXT
   */
  private function get_random_text()
  {
    $texts = [
      "This is a sample generated content.",
      "AI preview mode active. Add API key for real output.",
      "Demo content generated successfully.",
      "Sample AI response for testing.",
      "AI is not configured. Showing placeholder output."
    ];

    return $texts[array_rand($texts)];
  }
}
