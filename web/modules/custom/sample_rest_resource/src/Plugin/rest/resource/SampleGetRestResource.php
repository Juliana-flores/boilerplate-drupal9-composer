<?php

namespace Drupal\sample_rest_resource\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\Core\Entity\EntityInterface;
=======
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
>>>>>>> 5c2259e50a713185dc26a5585b56aeffa48d795e

/**
 * Provides a resource to get view modes by entity and bundle.
 * @RestResource(
 *   id = "custom_get_rest_resource",
 *   label = @Translation("Custom Get Rest Resource"),
 *   uri_paths = {
<<<<<<< HEAD
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
=======
 *     "canonical" = "/vb-rest"
 *   }
 * )
 */
class SampleGetRestResource extends ResourceBase
{
    /**
     * A current user instance which is logged in the session.
     * @var \Drupal\Core\Session\AccountProxyInterface
     */
    protected $loggedUser;
    /**
     * Constructs a Drupal\rest\Plugin\ResourceBase object.
     *
     * @param array $config
     *   A configuration array which contains the information about the plugin instance.
     * @param string $module_id
     *   The module_id for the plugin instance.
     * @param mixed $module_definition
     *   The plugin implementation definition.
     * @param array $serializer_formats
     *   The available serialization formats.
     * @param \Psr\Log\LoggerInterface $logger
     *   A logger instance.
     * @param \Drupal\Core\Session\AccountProxyInterface $current_user
     *   A currently logged user instance.
     */
    public function __construct(
        array $config,
        $module_id,
        $module_definition,
        array $serializer_formats,
        LoggerInterface $logger,
        AccountProxyInterface $current_user
    ) {
        parent::__construct($config, $module_id, $module_definition, $serializer_formats, $logger);

        $this->loggedUser = $current_user;
    }
    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $config, $module_id, $module_definition)
    {
        return new static(
            $config,
            $module_id,
            $module_definition,
            $container->getParameter('serializer.formats'),
            $container->get('logger.factory')->get('sample_rest_resource'),
            $container->get('current_user')
        );
    }
    /**
     * Responds to GET request.
     * Returns a list of taxonomy terms.
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * Throws exception expected.
     */
    public function get()
    {
        // Implementing our custom REST Resource here.
        // Use currently logged user after passing authentication and validating the access of term list.
        if (!$this->loggedUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }
        $vid = 'vb_test';
        $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => $vid]);
        foreach ($terms as $term) {
            $term_result[] = array(
                'id' => $term->tid,
                'name' => $term->name,
            );
        }

        $response = new ResourceResponse($term_result);
        $response->addCacheableDependency($term_result);
        return $response;
    }
}
>>>>>>> 5c2259e50a713185dc26a5585b56aeffa48d795e
