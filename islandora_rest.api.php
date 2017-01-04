<?php
/**
 * @file
 * This file documents all available hook functions for the Islandora REST module.
 */

/**
 * Notify modules of requests to Islandora REST endpoints other than 'solr'.
 *
 * @param string $endpoint
 *   The REST endpoint.
 * @param array $request_parameters
 *   An array containing all request parameters.
 * @param array $response
 *   An associative array version of the JSON response generated by the request.
 * @param object $e
 *   The exception generated during the Solr request,
 *   or NULL if request was successful.
 */
function hook_islandora_rest_response($endpoint, $request_parameters, $response, $e) {
  if ($e) {
    $vars = array('%endpoint' => $endpoint, '%object' => $request_parameters['pid'], '%message' => $e->getMessage());
    watchdog('islandora_rest', 'Islandora REST request to endpoint %endpoint for object: %object failed: %message',
     $vars, WATCHDOG_ERROR);
  }
  else {
    watchdog('islandora_rest', 'Islandora REST request to endpoint %endpoint for object: %object',
     array('%endpoint' => $endpoint, '%object' => $request_parameters['pid']));
  }
}

/**
 * Notify modules of requests to Islandora REST 'solr' endpoint.
 *
 * @param array $query
 *   The Solr query.
 * @param array $response
 *   The Solr query response (not the HTTP response).
 * @param object $e
 *   The exception generated during the Solr request,
 *   or NULL if request was successful.
 */
function hook_islandora_rest_solr_response($query, $response, $e) {
  if ($e) {
    $vars = array('%query' => $query['query'], '%message' => $e->getMessage());
    watchdog('islandora_rest', 'Islandora REST Solr query %query failed: %message', $vars);
  }
  else {
    $vars = array('%query' => $query['query'], '%numfound' => $response['response']['numFound']);
    watchdog('islandora_rest', 'Islandora REST Solr query %query returned %numfound objects', $vars);
  }
}
