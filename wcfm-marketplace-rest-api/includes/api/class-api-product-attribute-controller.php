<?php
class WCFM_REST_Product_Attribute_Controller extends WCFM_REST_Controller {
/**
   * Endpoint namespace
   *
   * @var string
   */
  protected $namespace = 'wcfmmp/v1';

  /**
   * Route name
   *
   * @var string
   */
  protected $base = 'products/attributes';

  /**
   * Post type
   *
   * @var string
   */
  protected $post_type = 'product';

  /**
   * Post status
   */
  protected $post_status = array( 'publish', 'pending', 'draft' );

  /**
    * Load autometically when class initiate
    *
    * @since 1.0.0
    */
    public function __construct() {
      
    }
    
    /**
     * Register all routes releated with stores
     *
     * @return void
     */
    public function register_routes() {
        register_rest_route( $this->namespace, '/' . $this->base, array(
            'args' => array(
                'id' => array(
                    'description' => __( 'Unique identifier for the object.', 'wcfm-marketplace-rest-api' ),
                    'type'        => 'integer',
                ),
            ),
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_items' ),
                'args'                => $this->get_collection_params(),
                'permission_callback' => array( $this, 'get_product_permissions_check' ),
            ),
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'create_item' ),
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
                'permission_callback' => array( $this, 'create_product_permissions_check' ),
            ),
            'schema' => array( $this, 'get_public_item_schema' ),
        ) );
        
        register_rest_route( $this->namespace, '/' . $this->base . '/(?P<id>[\d]+)/terms/', array(
            'args' => array(
                'id' => array(
                    'description' => __( 'Unique identifier for the object.', 'wcfm-marketplace-rest-api' ),
                    'type'        => 'integer',
                ),
            ),
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'create_terms' ),
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                'permission_callback' => array( $this, 'get_product_permissions_check' ),
            )
          )
        );
        
    }

        
    /**
     * get_product_permissions_check
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function get_product_permissions_check( $request ) {   
      return true;
    }

    
    // L05307582
    
    public function create_terms( $request ) {
      global $woocommerce;
      $attribute_id = isset( $request['id'] ) ? absint( $request['id'] ) : 0;
      $attribute_taxonomy_name = wc_attribute_taxonomy_name_by_id( $attribute_id );
      // wc_attribute_taxonomy_name();
      $term = wc_clean( $request['name'] );
      $taxonomy = $attribute_taxonomy_name;

      if ( taxonomy_exists( $taxonomy ) ) {

        $result = wp_insert_term( $term, $taxonomy );

        if ( is_wp_error( $result ) ) {
          wp_send_json( array(
            'error' => $result->get_error_message(),
          ) );
        } else {
          $term = get_term_by( 'id', $result['term_id'], $taxonomy );
          wp_send_json( array(
            'term_id' => $term->term_id,
            'name'    => $term->name,
            'slug'    => $term->slug,
          ) );
        }
      }

    }
}