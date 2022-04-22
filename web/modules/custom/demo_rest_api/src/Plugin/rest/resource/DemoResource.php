<?php

namespace Drupal\demo_rest_api\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\rest\ModifiedResourceResponse;

/**
 * Provides a Demo Resource
 *
 * @RestResource(
 *   id = "demo_resource",
 *   label = @Translation("Demo Resource"),
 *   uri_paths = {
 *     "canonical" = "/demo_rest_api/demo_resource"
 *   }
 * )
 */

class DemoResource extends ResourceBase {

     /**
   * Responds to entity GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Returning rest resource.
   */
  public function get() {

    if (\Drupal::request()->query->has('url') ) {
      
      $url = \Drupal::request()->query->get('url');
      
      if (!empty($url)) {
        
        $query = \Drupal::entityQuery('node')
          ->condition('field_unique_url', $url);
        $nodes = $query->execute();
       
        $node_id = array_values($nodes);

        if (!empty($node_id)) {
        
          $data = Node::load($node_id[0]);
          
          return new ModifiedResourceResponse($data);

      		}
      	}
 	}
  
  }

}

?>
