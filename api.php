<?php
  if (!empty($_POST)) {
      send_the_order($_POST);
  }
  function send_the_order($post){
    $params = array(
      'goods_id' => $post['goods_id'],
      'ip' => $_SERVER['REMOTE_ADDR'],
      'msisdn' => $post['phone'],
      'name' => $post['name'],
      'country' => $post['country'],
      'url_params[sub1]' => $post['sub1'],
      'url_params[sub2]' => $post['sub2'],
      'url_params[sub3]' => $post['sub3'],
      'url_params[sub4]' => $post['sub4'],
      'url_params[sub5]' => $post['sub5'],
      'url_params[utm_source]' => $post['utm_source'],
      'url_params[utm_content]' => $post['utm_content'],
      'url_params[utm_term]' => $post['utm_term'],
      'url_params[utm_campaign]' => $post['utm_campaign']
    );
    // write to file
    /*
    $fp = fopen('orders.txt', 'a');
    fwrite($fp, date("d-m-Y H:i:s"));
    fwrite($fp, ";");
    fwrite($fp, $params['name']);
    fwrite($fp, ";");
    fwrite($fp, $params['msisdn']);
    fwrite($fp, "\n");
    fclose($fp);
    */

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api-new.leadreaktor.com/api/order/create.php?api_key=9d450acf2dad45c793c17d4c0c28c476"); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    $return = curl_exec($ch);
    curl_close($ch);
    $array = json_decode($return, true);
    // var_dump ($array);
    // echo $array['msg'];
    $fbpixel = $_POST['fb_pixel'];
    header('Location:' . 'thankyou-ro.php?fb_pixel='.$fbpixel);

    // Show the error while testing
  	/*
    if (isset($array['response'])) $array = $array['response'];
    if ($array['msg'] == "error") {
  		header('Location:'.'error.php?msg='.$array['msg'].'&error='.$array['error']);
  	} else {
  		header('Location:'.'thanks.php?request_id='.$array['order_id']);
  	}
    */
  }
?>
