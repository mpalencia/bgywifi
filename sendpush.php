<?PHP
  function sendMessage(){
    $content = array(
      "en" => 'Test'
      );
    
    $fields = array(
      'app_id' => "e4c5f252-7bb2-11e5-902f-a0369f2d9328",
      'tags' => array(array('key'=>'userId', 'relation'=>'=','value'=>1)),
      'contents' => $content
    );
    
    $fields = json_encode($fields);


    print("\nJSON sent:\n");
    print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                           'Authorization: Basic ZTRjNWYyZjItN2JiMi0xMWU1LTkwMmYtYTAzNjlmMmQ5MzI4'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
  }
  
  $response = sendMessage();
  $return["allresponses"] = $response;
  $return = json_encode( $return);
  
  print("\n\nJSON received:\n");
  print($return);
  print("\n")
?>

