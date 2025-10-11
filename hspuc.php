<?php

require_once "conkt.php";

// Start the session
session_start();

if (!isset($_GET['username'])) {
    header('Location: htcm.php');
    exit; // Always exit after a header redirect
} else {
    $username = $_GET['username'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission

    // Retrieve form data
    $id = $_POST['id'];
    $action = $_POST['action'];
    $usernamee = $username;
    $wfprice = $_POST['wfprice'];
    $dw = $_POST['dw'];
    $mount = $_POST['menge'];
    $prod = $_POST['prod'];
    $menge = $_POST['menge'];

    // Store form data in session variables directly
	$_SESSION['id'] = $id;
    $_SESSION['action'] = $action;

    $_SESSION['username'] = $usernamee;
    $_SESSION['wfprice'] = $wfprice;
    $_SESSION['dw'] = $dw;
    $_SESSION['mount'] = $mount;
    $_SESSION['prod'] = $prod;
    $_SESSION['menge'] = $menge;


    // Redirect to trca1.php

    $url = "fcnmirdrop2.php?username=" . $username;
    header('location:' . $url);
    exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>
<link rel="icon" data-savepage-href="http://pz5uprzhnzeotviraa2fogkua5nlnmu75pbnnqu4fnwgfffldwxog7ad.onion/favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAD///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8AAMz/AADM/wAAzP8AAMz/////////////////AADM/wAAzP8AAMz/AADM/wAAzP////////////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz/////////////////////////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM//////////////////////8AAMz/AADM/wAAzP////////////////8AAMz/AADM////////////AADM/wAAzP////////////////8AAMz/AADM/wAAzP//////////////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM/////////////////////////////////wAAzP8AAMz///////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz//////wAAzP8AAMz/AADM////////////AADM/wAAzP8AAMz///////////8AAMz/AADM/wAAzP8AAMz/AADM////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta name="description" content="Become a citizen of the United States, get your US passport today!">
<link rel="icon" type="image/icon" data-savepage-href="favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAD///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8AAMz/AADM/wAAzP8AAMz/////////////////AADM/wAAzP8AAMz/AADM/wAAzP////////////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz/////////////////////////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM//////////////////////8AAMz/AADM/wAAzP////////////////8AAMz/AADM////////////AADM/wAAzP////////////////8AAMz/AADM/wAAzP//////////////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM/////////////////////////////////wAAzP8AAMz///////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz//////wAAzP8AAMz/AADM////////////AADM/wAAzP8AAMz///////////8AAMz/AADM/wAAzP8AAMz/AADM////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">	
<link rel="shortcut icon" type="image/icon" data-savepage-href="favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAD///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8AAMz/AADM/wAAzP8AAMz/////////////////AADM/wAAzP8AAMz/AADM/wAAzP////////////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz/////////////////////////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM//////////////////////8AAMz/AADM/wAAzP////////////////8AAMz/AADM////////////AADM/wAAzP////////////////8AAMz/AADM/wAAzP//////////////////////AADM/wAAzP///////////wAAzP8AAMz///////////8AAMz/AADM/////////////////////////////////wAAzP8AAMz///////////8AAMz/AADM////////////AADM/wAAzP///////////wAAzP8AAMz//////wAAzP8AAMz/AADM////////////AADM/wAAzP8AAMz///////////8AAMz/AADM/wAAzP8AAMz/AADM////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">
<title>USA Citizenship - Become a citizen of the USA today, possible for everyone. Payment with bitcoin.</title>
<style type="text/css">
body {
background:#3F3D45;
color:#BBB;
margin:0;
padding:0
}

body,.txt,textarea {
font:13px Verdana,Tahoma,sans-serif
}

div {
position:relative
}

:focus {
outline:none
}

::-moz-focus-inner,img {
border:0
}

strong,b {
color:#FFF
}

#header {
-moz-border-radius:0 0 20px 20px;
-webkit-border-radius:0 0 20px 20px;
border-color:#1F1F1F;
border-radius:0 0 20px 20px;
border-style:solid;
border-width:0 4px 4px;
color:#BBB;
height:78px;
left:50%;
margin-left:-469px;
position:absolute;
width:930px;
z-index:4
}

#header,#main {
-moz-box-shadow:0 0 35px rgba(255,255,255,0.5);
-webkit-box-shadow:0 0 35px rgba(255,255,255,0.5);
box-shadow:0 0 35px rgba(255,255,255,0.5)
}

#main {
-moz-border-radius:15px;
-webkit-border-radius:15px;
background:#3F3D45;
border:3px solid #3F3D45;
border-radius:15px;
margin:0 auto 30px;
padding:83px 20px 0;
width:850px;
z-index:2
}

#menu {
height:50px;
left:50%;
margin-left:-90px;
margin-top:-30px;
position:absolute;
top:50%;
width:550px
}

#menu a:link,#menu a:visited {
float:right;
margin-right:4px;
padding:4px;
text-align:center
}

#menu a:hover,#menu a:focus,.buttn:hover,.buttn:focus {
background-color:#FFF
}

#menu a:focus {
padding:4px 3px 4px 5px
}

#menu a,h3 {
-moz-border-radius:7px;
-webkit-border-radius:7px;
border-radius:7px
}

#menu a,.buttn {
background:#D1A779;
color:#000;
cursor:pointer
}

#menu a,.buttn,.txt,textarea {
border:2px solid #D1A779
}

#menu a:focus,.buttn:focus,.txt:focus,textarea:focus {
-moz-box-shadow:0 0 6px rgba(255,255,255,0.7);
-webkit-box-shadow:0 0 6px rgba(255,255,255,0.7);
box-shadow:0 0 6px rgba(255,255,255,0.7)
}

.buttn {
height:26px
}

.buttn,.txt,.table1 td,.table1 th,.floatimg {
-moz-border-radius:5px;
-webkit-border-radius:5px;
border-radius:5px
}

.txt {
height:20px;
margin:7px 0;
text-align:center
}

.txt,textarea {
background:#000;
color:#BBB
}

textarea {
-moz-border-radius:10px;
-webkit-border-radius:10px;
border-radius:10px;
overflow:auto;
padding:8px
}

input.checkb {
margin-top:15px
}

a:link,a:visited {
font-size:13px;
text-decoration:none
}

a:link,a:visited,#warning {
color:red;
font-weight:700
}

a:hover,a:focus {
color:#FFF
}

h3 {
color:#AD9FD5;
font-size:22px;
font-weight:500;
padding:5px 8px
}

#header,h3,.table1 td {
background:#1F1F1F
}

hr {
border:1px solid #D1A779
}

.table1 td,.table1 th,.floatimg {
-moz-box-shadow:0 0 3px rgba(0,0,0,0.75);
-webkit-box-shadow:0 0 3px rgba(0,0,0,0.75);
box-shadow:0 0 3px rgba(0,0,0,0.75)
}

.table1 th {
background:#35312D;
color:#FFF
}
.table1 th,.table1 td {
padding:5px 7px;
text-align:left
}

.floatimg {
margin:0 19px 19px 0
}

#checkout {
font-size:28px
}

#footer {
height:60px;
width:870px
}

#footertext {
font-size:11px;
left:318px;
text-align:center;
top:29px;
width:212px
}
</style>

<style id="savepage-cssvariables">
  :root {
  }
</style>
<script id="savepage-shadowloader" type="text/javascript">
  "use strict";
  window.addEventListener("DOMContentLoaded",
  function(event) {
    savepage_ShadowLoader(5);
  },false);
  function savepage_ShadowLoader(c){createShadowDOMs(0,document.documentElement);function createShadowDOMs(a,b){var i;if(b.localName=="iframe"||b.localName=="frame"){if(a<c){try{if(b.contentDocument.documentElement!=null){createShadowDOMs(a+1,b.contentDocument.documentElement)}}catch(e){}}}else{if(b.children.length>=1&&b.children[0].localName=="template"&&b.children[0].hasAttribute("data-savepage-shadowroot")){b.attachShadow({mode:"open"}).appendChild(b.children[0].content);b.removeChild(b.children[0]);for(i=0;i<b.shadowRoot.children.length;i++)if(b.shadowRoot.children[i]!=null)createShadowDOMs(a,b.shadowRoot.children[i])}for(i=0;i<b.children.length;i++)if(b.children[i]!=null)createShadowDOMs(a,b.children[i])}}}
</script>
<meta name="savepage-url" content="http://pz5uprzhnzeotviraa2fogkua5nlnmu75pbnnqu4fnwgfffldwxog7ad.onion/login.php">
<meta name="savepage-title" content="USA Citizenship - Become a citizen of the USA today, possible for everyone. Payment with bitcoin.">
<meta name="savepage-pubdate" content="Unknown">
<meta name="savepage-from" content="http://pz5uprzhnzeotviraa2fogkua5nlnmu75pbnnqu4fnwgfffldwxog7ad.onion/login.php">
<meta name="savepage-date" content="Thu Mar 14 2024 00:47:25 GMT+0200 (Eastern European Standard Time)">
<meta name="savepage-state" content="Standard Items; Retain cross-origin frames; Merge CSS images; Remove unsaved URLs; Load lazy images in existing content; Max frame depth = 5; Max resource size = 50MB; Max resource time = 10s;">
<meta name="savepage-version" content="28.11">
<meta name="savepage-comments" content="">
  </head>
<body>

<div id="header">
<a data-savepage-href="index.php" href="http://pz5uprzhnzeotviraa2fogkua5nlnmu75pbnnqu4fnwgfffldwxog7ad.onion/index.php">    <img data-savepage-currentsrc="http://pz5uprzhnzeotviraa2fogkua5nlnmu75pbnnqu4fnwgfffldwxog7ad.onion/logo.png" data-savepage-src="logo.png" src="data:image/png;base64,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" alt="USA Citizenship - Become a citizen of the USA today, possible for everyone. Payment with bitcoin."></a>

<div id="menu"> 
<a data-savepage-href="messages.php" href="gfs2.php?username=<?=$username?>" title="Contact support">Messages (1)</a> <br><br>
 
 
<a data-savepage-href="" href="hspuc.php?username=<?=$username?>" title="Products">Products</a>
</div></div><div id="main">

<h3>Become a citizen of the USA, real USA passport</h3><img data-savepage-currentsrc="http://pz5uprzhnzeotviraa2fogkua5nlnmu75pbnnqu4fnwgfffldwxog7ad.onion/products/cat/100/image.jpg" data-savepage-src="products/cat/100/image.jpg" src="data:image/jpeg;base64,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" class="floatimg" style="float:left" alt="">We offer bulletproof USA passports + SSN + Drivers License and Birth Certificate and other papers making you an official citizen of the USA!<br>
It will even work if you are not in the USA yet<br>
<br>
How we do it? Trade secret! But we can assure you that you won't have any problems with our papers.<br>
We are shipping documents from the USA, international shipping is no problem.<br>
You can use your own name or a new name!<br>
Information on how to send us required info (scanned signature, biometric picture etc) will be given after purchase.<br>
<br>
<strong>The total price is 4000 USD</strong>, 1000 USD paid when you order and the other 3000 when we show you photo and video proof of your passport.<br>
The first 1000 USD are needed upfront to see you are serious about it. Once paid we will discuss details in our shop internal message system.<br><br><br><br><table class="table1">
<thead>
<tr>
<th>Product</th><th>Price</th><th>Quantity</th>
</tr>
</thead>
<tbody>
<tr>
<td>Your USA citizenship first payment 25% 1000/4000</td><td>1500 USD</td><td>
<form name="cart" method="post" action="">
<input value="100" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="1500" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="Your USA citizenship first payment 25% 1000/4000" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>US bank account with online banking and card. Great for cashing out bitcoin. Accounts will last at least 8 years.</td><td>1000 USD</td><td>
<form name="cart" method="post" action="">
<input value="101" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="1000" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value=">US bank account with online banking and card" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
</tbody>
</table>
<br>
<br>
</div>
</body></html>