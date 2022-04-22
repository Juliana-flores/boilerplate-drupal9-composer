<?php

namespace Drupal\sample_rest_resource\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "custom_get_rest_resource",
 *   label = @Translation("Custom Get Rest Resource"),
 *   uri_paths = {
 *     "canonical" = "/sample_rest_resource/custom_get_rest_resource"
 *   }
 * )
 */
class SampleGetRestResource extends ResourceBase {
   /**
   * Responds to entity GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   Returning rest resource.
   */
  public function get()
  {
    // Implementing our custom REST Resource here.
    // Use currently logged user after passing authentication and validating the access of term list.
    // if (!$this->loggedUser->hasPermission('access content')) {
    //   throw new AccessDeniedHttpException();
    // }
//     $values = [
//       'type' => 'tweets',
//     ];
//     $nodes = \Drupal::entityTypeManager()
//       ->getStorage('node')
//       ->loadByProperties($values);
//     $id = 0;

//     foreach ($nodes as $key => $object) {
//       echo ($key);
//       echo ($object->title->getString());
//       echo ($object->id());
//       $id = $object->id();
//     }
//     $node_detail = \Drupal::entityTypeManager()
//       ->getStorage('node')
//       ->load($id);
//     echo print_r($node_detail->title->getString());

//     return $nodes;
//   }
// }

    $nids = \Drupal::entityQuery('node')->condition('type','tweets')->execute();
 
    $nodes =  Node::loadMultiple($nids);

    $json_array = array(
      'data' => array()
    );
    
    foreach ($nodes as $_ => $node) {
      $json_array['data'][] = array(
        'Title'=> $node->getTitle(),
        'Username' => $node->get('field_username')->value,
        'Tweet' => $node->get('field_tweet')->value,
        'Created' => $node->getCreatedTime(),
        
      );
    }

    // foreach ($nodes as $_ => $node) {
    //   $json_array['data'][] = array(
    //     'Book_author' => $node->get('field_book_author')->value,
    //     'Created' => $node->getCreatedTime(),
    //     'Title'=> $node->getTitle(),
    //   );
    // }
    return new JsonResponse($json_array);
  }
}