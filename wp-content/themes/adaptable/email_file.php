<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
//echo "sainath";
$email_content = esc_attr($_POST['email_content']);
$email_subject = esc_attr($_POST['Subject']);
$email = $_POST['Email'];
$name = esc_attr($_POST['Name']);
$car = $_POST['Vehicle_ID'];
$post_type = get_post_type($car);
if($post_type=="cars") { $address = get_post_meta($car,'imic_plugin_contact_email',true); if($address=='') { $address = get_option('admin_email'); } }
else { $address = get_option('admin_email'); }
echo $car;
$subject = $email_subject;
global $imic_options;
$body = $name. __(' has contacted you for below enquiry','framework');
if(!empty($imic_options[$email_content])){	
	$u_body = $imic_options[$email_content];
}else{
	$u_body=__("You information has been received, we will contact you shortly.",'framework');
}	
$e_content = '';
foreach($_POST as $key=>$value) {
	if($key!="email_content"&&$key!="Subject") {
		if($key=="Vehicle_ID")
		{
			$post = get_post($value);
			$e_content .= "<p><a href='" . get_permalink($value) . "' target='_blank'>".esc_attr__("Link to Listing: ", "framework") . $post->post_title . "</a></p>";
		}
		else
		{
			$e_content .= "<p>$key: $value</p>";
		}
	}
}
//$e_reply = __("You can contact","framework"). $name .__("via email","framework").", $email";		

$msg = wordwrap( $body . $e_content, 70 );
$msgs = wordwrap( $u_body, 70 );

$msg = '<img src="http://' . $_SERVER['HTTP_HOST'] . '/wp-content/uploads/2016/07/VA_logo.jpg" alt="Vintage Steering"><br><br>' . $msg;

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers.="Content-Type: text/html; charset=\"iso-8859-1\"\n";
$header = "From: $address" . PHP_EOL;
$header .= "Reply-To: $address" . PHP_EOL;
$header .= "MIME-Version: 1.0" . PHP_EOL;
$header .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";

//wp_mail($address, $subject, $msg, $headers);
if(isset($_POST['Friendemail'])) {
    wp_mail($_POST['Friendemail'], $subject, $msg, $header);
} else {
wp_mail($email, $subject, $msg, $header);
}
?>