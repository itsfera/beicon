<?php

header("Content-Type: application/json");

// Allow Credentials
header('Access-Control-Allow-Credentials: true');

// Allow all origins
if (isset($_SERVER['HTTP_REFERER']) || isset($_SERVER['HTTP_ORIGIN'])) {
  if (isset($_SERVER['HTTP_REFERER'])) {
      $url_components = parse_url($_SERVER['HTTP_REFERER']);
        } else if (isset($_SERVER['HTTP_ORIGIN'])) {
            $url_components = parse_url($_SERVER['HTTP_ORIGIN']);
              }
                if (isset($url_components['port'])) {
                    header('Access-Control-Allow-Origin: ' . $url_components['scheme'] . '://' . $url_components['host'] . ':' . $url_components['port']);
                      } else {
                          header('Access-Control-Allow-Origin: ' . $url_components['scheme'] . '://' . $url_components['host']);
                            }
                            } else {
                              header('Access-Control-Allow-Origin: *');
                              }
                              
                              // Specify which request methods are allowed
                              header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
                              
                              // Additional headers which may be sent along with the CORS request
                              // The X-Requested-With header allows jQuery requests to go through
                              //header('Access-Control-Allow-Headers: X-Requested-With');
                              header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
                              
                              
                              // Any other custom headers that you want to add
                              // This is just example :)
                              header('Access-Control-Expose-Headers: X-Olaround-Debug-Mode, X-Olaround-Request-Start-Timestamp, X-Olaround-Request-End-Timestamp, X-Olaround-Request-Time, X-Olaround-Request-Method, X-Olaround-Request-Result, X-Olaround-Request-Endpoint');
                              
                              //// Exit early so the page isn't fully loaded for options requests
                              //if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') {
                              //  exit();
                              //}
                              
                              echo json_encode(array("Message" => "OK!"));
                              ?>