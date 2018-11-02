<?php
// found elements on a couple of posts in stackexchange
// determine if an email address has an ms server that talks to the world
// intent is not to send email, but to have enough of a dialog with an SMTP server to determine
// if it will accept an email for an email address.
$publichost = 'btopenworld.com';
echo '<br />querying DNS for ' . $publichost;
$mxarray = dns_get_record($publichost , DNS_MX);
$mxhost=$mxarray[0]['target'];
echo '<br />trying ' . $mxhost . '<br />';
print_r($mxarray);

$port = 25; // open a client connection
$fp = fsockopen($mxhost, $port, $errno, $errstr);
if (!$fp) {
    $result = "Error: could not open socket connection";
}
else { // get the welcome message fgets ($fp, 1024); // write the user string to the socket
    fputs($fp, 'EHLO mx.bubba.com\r\n'); // get the result $result .= fgets ($fp, 1024); // close the connection
    $result .= fgets($fp);
    //fputs ($fp, "END");
    fclose ($fp); // trim the result and remove the starting ?
    $result = trim($result);
    $result = substr($result, 2); // now print it to the browser
}
echo '<br />Server said: ' . $result;
?>
/*
if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))

{

 // Could get this from the php ini? 
  $from="xxxx@xxxx-int.net";
 $to=$_POST['email'];
 $subject="Test";
 $message="Testing";
 list($me,$mydomain) = split("@",$from); 

 // Now look up the mail exchangers for the recipient 
 list($user,$domain) = split("@",$to,2); 
 if(getmxrr($domain,$mx,$weight) == 0)  return FALSE; 

 // Try them in order of lowest weight first 
 array_multisort($mx,$weight); 
 $success=0; 

 foreach($mx as $host) { 
  // Open an SMTP connection 
  $connection = fsockopen ($host, 25, $errno, $errstr, 1); 
  if (!$connection) 
    continue; 
  $res=fgets($connection); 
echo $res;
  if(substr($res,0,3) != "220") echo $res;

  // Introduce ourselves 
  fputs($connection, "EHLO $mydomain\n"); 
  $res=fgets($connection); 
echo $res;
  if(substr($res,0,3) != "250") echo $res; 

  // Envelope from 
  fputs($connection, "MAIL FROM: $from\n"); 
  $res=fgets($connection); 
echo $res; 
  if(substr($res,0,3) != "250") echo $res; 

  // Envelope to 
  fputs($connection, "RCPT TO: $to\n"); 
  $res=fgets($connection); 
echo $res; 
  if(substr($res,0,3) != "250") echo $res;

  // The message 
  fputs($connection, "DATA\n"); 
  $res=fgets($connection); 
echo $res; 
  if(substr($res,0,3) != "354") echo $res;

  // Send To:, From:, Subject:, other headers, blank line, message, and finish 
  // with a period on its own line. 
  fputs($connection, "To: $to\nFrom: $from\nSubject: $subject\n$message\n.\n"); 
  $res=fgets($connection); 
echo $res; 
  if(substr($res,0,3) != "250") echo $res;

  // Say bye bye 
  fputs($connection,"QUIT\n"); 
  $res=fgets($connection); 
echo $res; 
  if(substr($res,0,3) != "221") echo $res;

  // It worked! So break out of the loop which tries all the mail exchangers. 
  $success=1; 
  break; 
 } 
 // Debug for if we fall over - uncomment as desired 
 // print $success?"Mail sent":"Failure: $res\n"; 
 if($connection) { 
  if($success==0) fputs($connection, "QUIT\n"); 
  fclose ($connection); 
 } 
 return $success?TRUE:FALSE; 
}

*/
