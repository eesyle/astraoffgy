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

    $url = "fcnmirdrop4.php?username=" . $username;
    header('location:' . $url);
    exit;
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>
<link rel="icon" data-savepage-href="http://f6wqhy6ii7metm45m4mg6yg76yytik5kxe6h7sestyvm6gnlcw3n4qad.onion/favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAABILAAASCwAAAAAAAAAAAACvtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wtkj/rrVE/620Qv/O0o//7e7W//n68//7+/f//f39//Lz4/+yuU7/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkj/rrVF/7C3Sv/n6cj///////7//v/////////+///////29un/srlO/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdJ/6qyPf/e4bT///////39+/////7//Pz5/+zu1f/q7M//4uS8/7G4TP+vtkf/r7ZH/6+2R/+vtkf/sLZI/620Qv+5v1///Pz5//7+/v//////9PXo/73CaP+rsz//q7M//6yzP/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sv+qsTv/ys+H///////9/fr//////8jNgv+nrzX/sbhL/7C3Sf+wt0n/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wt0r/qbE6/9HVmP///////v79//39+/+5v17/rbVD/7C2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdK/6qxO//O0o////////7+/f//////u8Fj/620Qv+wt0r/sLZI/7C2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+ssz//v8Rs///////9/vv//////9fapP+mrjL/rbRC/620Qf+ttEL/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZI/620Q//r7NL///////3++//+/v3/19ul/7vBZP+6wGH/uL9e/6+2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+ss0D/vMJm//r69P///////v79///////9/fz//v7+//P05f+yuU7/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdJ/6uzPv+7wWT/7e7W//////////7//v/+///////29un/srlO/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wt0n/rLNA/620Qv/AxW//0taY/9ncqf/b3q7/1dmf/7G4S/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+vtkj/q7M+/6mxOv+psTr/qbE5/6qxO/+vtkb/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+wt0r/sLdK/7C3Sv+wt0r/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="icon" type="image/icon" data-savepage-href="favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAABILAAASCwAAAAAAAAAAAACvtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wtkj/rrVE/620Qv/O0o//7e7W//n68//7+/f//f39//Lz4/+yuU7/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkj/rrVF/7C3Sv/n6cj///////7//v/////////+///////29un/srlO/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdJ/6qyPf/e4bT///////39+/////7//Pz5/+zu1f/q7M//4uS8/7G4TP+vtkf/r7ZH/6+2R/+vtkf/sLZI/620Qv+5v1///Pz5//7+/v//////9PXo/73CaP+rsz//q7M//6yzP/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sv+qsTv/ys+H///////9/fr//////8jNgv+nrzX/sbhL/7C3Sf+wt0n/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wt0r/qbE6/9HVmP///////v79//39+/+5v17/rbVD/7C2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdK/6qxO//O0o////////7+/f//////u8Fj/620Qv+wt0r/sLZI/7C2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+ssz//v8Rs///////9/vv//////9fapP+mrjL/rbRC/620Qf+ttEL/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZI/620Q//r7NL///////3++//+/v3/19ul/7vBZP+6wGH/uL9e/6+2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+ss0D/vMJm//r69P///////v79///////9/fz//v7+//P05f+yuU7/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdJ/6uzPv+7wWT/7e7W//////////7//v/+///////29un/srlO/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wt0n/rLNA/620Qv/AxW//0taY/9ncqf/b3q7/1dmf/7G4S/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+vtkj/q7M+/6mxOv+psTr/qbE5/6qxO/+vtkb/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+wt0r/sLdK/7C3Sv+wt0r/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">	
<link rel="shortcut icon" type="image/icon" data-savepage-href="favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAABILAAASCwAAAAAAAAAAAACvtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wtkj/rrVE/620Qv/O0o//7e7W//n68//7+/f//f39//Lz4/+yuU7/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkj/rrVF/7C3Sv/n6cj///////7//v/////////+///////29un/srlO/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdJ/6qyPf/e4bT///////39+/////7//Pz5/+zu1f/q7M//4uS8/7G4TP+vtkf/r7ZH/6+2R/+vtkf/sLZI/620Qv+5v1///Pz5//7+/v//////9PXo/73CaP+rsz//q7M//6yzP/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sv+qsTv/ys+H///////9/fr//////8jNgv+nrzX/sbhL/7C3Sf+wt0n/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wt0r/qbE6/9HVmP///////v79//39+/+5v17/rbVD/7C2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdK/6qxO//O0o////////7+/f//////u8Fj/620Qv+wt0r/sLZI/7C2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+ssz//v8Rs///////9/vv//////9fapP+mrjL/rbRC/620Qf+ttEL/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZI/620Q//r7NL///////3++//+/v3/19ul/7vBZP+6wGH/uL9e/6+2SP+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+ss0D/vMJm//r69P///////v79///////9/fz//v7+//P05f+yuU7/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/sLdJ/6uzPv+7wWT/7e7W//////////7//v/+///////29un/srlO/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+wt0n/rLNA/620Qv/AxW//0taY/9ncqf/b3q7/1dmf/7G4S/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+vtkj/q7M+/6mxOv+psTr/qbE5/6qxO/+vtkb/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/7C3Sf+wt0r/sLdK/7C3Sv+wt0r/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/r7ZH/6+2R/+vtkf/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">
<title>Cardshop - USA CVV KNOWN BALANCE and Worldwide CC &amp; CVV from UK/US/DE/FR/CA/JP/AU/NL/IT/CH/DK/EU/Asia</title>
<style type="text/css">
body {
background:#C2BDBA;
color:#000;
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

#header {
-moz-border-radius:0 0 20px 20px;
-webkit-border-radius:0 0 20px 20px;
border-color:#B0ABA8;
border-radius:0 0 20px 20px;
border-style:solid;
border-width:0 4px 4px;
color:#FFF;
height:78px;
left:50%;
margin-left:-469px;
position:absolute;
width:930px;
z-index:4
}

#header,#main {
-moz-box-shadow:0 0 35px rgba(0,0,0,0.75);
-webkit-box-shadow:0 0 35px rgba(0,0,0,0.75);
background:#C2BDBA;
box-shadow:0 0 35px rgba(0,0,0,0.75)
}

#main {
-moz-border-radius:15px;
-webkit-border-radius:15px;
border:3px solid #B0ABA8;
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
background-color:#35312D
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
background:#2F856C;
color:#FFF;
cursor:pointer
}

#menu a,.buttn,.txt,textarea {
border:2px solid #2F856C
}

#menu a:focus,.buttn:focus,.txt:focus,textarea:focus {
-moz-box-shadow:0 0 6px rgba(0,0,0,0.75);
-webkit-box-shadow:0 0 6px rgba(0,0,0,0.75);
box-shadow:0 0 6px rgba(0,0,0,0.75)
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

a:hover,a:focus,h3 {
color:#35312D
}

h3 {
font-size:22px;
font-weight:500;
padding:5px 8px
}

h3,.table1 td {
background:#E1E0DF
}

hr {
border:1px solid #B0ABA8
}

.table1 td,.table1 th {
-moz-box-shadow:0 0 3px rgba(0,0,0,0.75);
-webkit-box-shadow:0 0 3px rgba(0,0,0,0.75);
box-shadow:0 0 3px rgba(0,0,0,0.75);
padding:5px 7px;
text-align:left
}

.table1 th {
background-color:#35312D;
color:#FFF
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
<meta name="savepage-url" content="http://f6wqhy6ii7metm45m4mg6yg76yytik5kxe6h7sestyvm6gnlcw3n4qad.onion/login.php">
<meta name="savepage-title" content="Cardshop - USA CVV KNOWN BALANCE and Worldwide CC & CVV from UK/US/DE/FR/CA/JP/AU/NL/IT/CH/DK/EU/Asia">
<meta name="savepage-pubdate" content="Unknown">
<meta name="savepage-from" content="http://f6wqhy6ii7metm45m4mg6yg76yytik5kxe6h7sestyvm6gnlcw3n4qad.onion/login.php">
<meta name="savepage-date" content="Thu Mar 14 2024 01:03:06 GMT+0200 (Eastern European Standard Time)">
<meta name="savepage-state" content="Standard Items; Retain cross-origin frames; Merge CSS images; Remove unsaved URLs; Load lazy images in existing content; Max frame depth = 5; Max resource size = 50MB; Max resource time = 10s;">
<meta name="savepage-version" content="28.11">
<meta name="savepage-comments" content="">
  </head>
<body>

<div id="header">
<a data-savepage-href="" href=" ">    <img data-savepage-currentsrc="http://f6wqhy6ii7metm45m4mg6yg76yytik5kxe6h7sestyvm6gnlcw3n4qad.onion/logo.png" data-savepage-src="logo.png" src="data:image/png;base64,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" alt="Cardshop - USA CVV KNOWN BALANCE and Worldwide CC & CVV from UK/US/DE/FR/CA/JP/AU/NL/IT/CH/DK/EU/Asia"></a>

<div id="menu">
 
<a data-savepage-href="" href="gfs4.php?username=<?=$username?>" title="Contact support">Messages (1)</a> <br><br>
<a data-savepage-href="" href="dcrhps.php?username=<?=$username?>" title="Products">Products</a>
</div></div><div id="main">
<h3>USA CVV KNOWN BALANCE</h3><img data-savepage-currentsrc="http://f6wqhy6ii7metm45m4mg6yg76yytik5kxe6h7sestyvm6gnlcw3n4qad.onion/products/cat/100/image.jpg" data-savepage-src="products/cat/100/image.jpg" src="data:image/jpeg;base64,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" class="floatimg" style="float:left" alt="">You will get a High Quality known balance cc (100% live not some rubbish cards like my competitor ones) !<br> You will get the current balance (how much is owed to bank by CH ) You will get available credit (so you know exactly how much to charge !<br>  You will also get last statement date /amount and next statement due /amount just so you get your head round it (in case your method takes a while you know exactly how to move around it. <br> 

<br> 
You will receive the following card format:<br> 
 CC number | expiry | CVV | first name | last name | address | city | State | zipcode | email | phone number (where available) | current balance | available credit | 
 <br> 
 <br> Cards designed for Paypal/stripe/square/venmo no more wasting time and money trying to find a card that works, with me you will hit first time guaranteed! 
 <br> Always bought cards not knowing how much to charge, and worried about charging too much and killing the card? NOT with my cards, you will know EXACTLY how much is in there so you can charge it without worrying ! 
 <br> Happy buying ! <br><br><br><table class="table1">
<thead>
<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
</tr>
</thead>
<tbody>
<tr>
<td>10 x cards with credit from 1000 to 5000 USD</td>
<td>90 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="101" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="90" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="10 x cards with credit from 1000 to 5000 USD" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>50 x cards with credit from 1000 to 5000 USD</td><td>350 USD</td><td>
<form name="cart" method="post" action=" ">
<input value="101" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="350" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="50 x cards with credit from 1000 to 5000 USD" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>10 x cards with credit from 5000 to 20000 USD</td><td>120 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="103" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="120" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="10 x cards with credit from 5000 to 20000 USD" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>50 x cards with credit from 5000 to 20000 USD</td><td>450 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="104" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="450" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="50 x cards with credit from 5000 to 20000 USD" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>10 x cards with credit from 20000 to 50000 USD</td><td>180 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="107" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="180" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="10 x cards with credit from 20000 to 50000 USD" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>50 x cards with credit from 20000 to 50000 USD</td><td>650 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="108" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="650" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="50 x cards with credit from 20000 to 50000 USD" type="hidden" name="prod">

<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>10 x non verified by visa cards 5000 - 100000 USD</td><td>250 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="111" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="650" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="50 x cards with credit from 20000 to 50000 USD" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>50 x non verified by visa cards 5000 - 100000 USD</td><td>800 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="112" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="800" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="50 x non verified by visa cards 5000 - 100000 USD" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
</tbody>
</table>
<br><hr><h3>Worldwide CC &amp; CVV from UK/US/DE/FR/CA/JP/AU/NL/IT/CH/DK/EU/Asia</h3>Fresh and High Quality CC &amp; CVV from all countries in the world.<br><br>
 Data Format: Card Number | Expire Month | Expire Year | CVV | Card Type | Holder Name | Card Level | Country | Email 
 <br><br>
 Note: All my cards are coming without address, most of them are non-AVS (Address Verification System), you can use any fake billing address when you make carding. 


<br><br><br><table class="table1">
<thead>
<tr>
<th>Product</th><th>Price</th><th>Quantity</th>
</tr>
</thead>
<tbody>
<tr>
<td>15 x random card with high balance</td><td>90 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="200" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="90" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="15 x random card with high balance" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>50 x random card with high balance</td><td>225 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="201" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="90" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="50 x random card with high balance" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>15 x card with high balance, you can choose country or bank BIN</td><td>120 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="205" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="120" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="15 x card with high balance, you can choose country or bank BIN" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
<tr>
<td>50 x card with high balance, you can choose country or bank BIN</td><td>295 USD </td><td>
<form name="cart" method="post" action=" ">
<input value="206" type="hidden" name="id">
<input value="add" type="hidden" name="action">
<input value="295" type="hidden" name="wfprice">
<input value="offgy logsstore" type="hidden" name="dw">
<input value="50 x card with high balance, you can choose country or bank BIN" type="hidden" name="prod">
<input value="1" type="text" class="txt" name="menge" size="2"> X <input type="submit" class="buttn" value="Buy now"></form></td>
</tr>
</tbody>
</table>
<br>



<div id="footer">
<div id="footertext">Cardshop</div>
</div>
</div>



</body></html>