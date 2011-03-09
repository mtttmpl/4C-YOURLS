<?php
require_once( dirname(dirname(__FILE__)).'/includes/load-yourls.php' );

yourls_html_head( 'tools', 'Contact' );
yourls_html_logo();
?>

<div class="sub_wrap">	
<?php
$to  = 'contact@4c.to';

// subject
$subject = $_POST['s'];

// message
$message = $_POST['m'];

//build from var
$name = $_POST['n'];
$e = $_POST['e'];
$from = $n . ' <' . $e . '>';

// headers
$headers = 'From: '.$from. "\r\n";

if(isset($message)) {
// Mail it
mail($to, $subject, $message, $headers);
$sent = 'true';
}
?>
<h1>Contact</h1>

<?php
if($sent=='true') {
	echo 'Your message has been sent <p />';	
}
?>

<form id="email" name="form1" method="post" action="">
  <p>
    <label>Name
      <input type="text" name="n" id="n" />
    </label>
    <br />
    <label>Email
      <input type="text" name="e" id="e" />
    </label>
    <br />
     </label>
    <br />
    <label>Subject
      <input type="text" name="s" id="s" />
    </label>
    <br />
    <label>Message
      <textarea name="m" id="m" cols="45" rows="5"></textarea>
    </label>
    <br />
    <label>
      <input type="submit" name="send" id="send" value="Send" />
    </label>
  </p>
</form>

</div>


<?php yourls_html_footer(); ?>
	


