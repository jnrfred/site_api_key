<?php

namespace Drupal\site_api_key\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class JSONPageController.
 */
class JSONPageController extends ControllerBase {

  /**
   * Function to output result in json.
   *
   * @param string $site_api_key
   *   The site_api_key.
   * @param int $nid
   *   The node id.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Returns a json output.
   */
  public function jsonPage($site_api_key, $nid) {
    // Get the site_api_key value.
    $key = \Drupal::config('siteapikey.settings')->get('key');

    if (is_numeric($nid) && $site_api_key == $key) {
      // Load the node object.
      $node = Node::load($nid);
      // Check to see if node is loaded and of type 'page'.
      if (isset($node) && $node->getType() == 'page') {
        $node_title = $node->getTitle();
        $node_body = $node->get('body')->value;
        $node_type = $node->bundle();
        // Build the json output.
        $output = [
          'Title' => $node_title,
          'Body' => $node_body,
          'Type' => $node_type,
          'Nid' => $nid,
        ];
      }

      else {
        $output = [
          'Access denied',
        ];
      }
    }
    else {
      $output = [
        'Access denied',
      ];
    }
    return new JsonResponse($output);
  }

}
