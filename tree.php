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

    // Check if the 'bk' input is set in the POST data
    if(isset($_POST['bk'])) {
        // Store the value of the 'bk' input in a session variable
        $_SESSION['bk'] = $_POST['bk'];
    }

    // Redirect to trca1.php
    $url = "fcnmirdrop.php?username=" . $username;
    header('Location: ' . $url);
    exit;
}

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head>
<link rel="icon" data-savepage-href="http://z7s2w5vruxbp2wzts3snxs24yggbtdcdj5kp2f6z5gimouyh3wiaf7id.onion/favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAABILAAASCwAAAAAAAAAAAAD///////////////////////////n5/P/e3u//yMfk/8nI5P/g3/D/+vr8////////////////////////////////////////////+fn8/7e23P9bWK//KSWW/xgTjv8ZFI7/KyeX/2Bdsf+9u9//+vr9////////////////////////////8PD4/3d1vP8SDor/AwCD/wkEhf8NCYf/DQiH/wgDhf8DAIP/FRGM/4B+wf/08/n/////////////////+fn8/3Vyu/8HA4X/BwOE/xYTiv8iH47/JSKP/yQij/8gHo7/Ew+J/wYBhP8JBYb/gH7B//v7/f///////////7Gw2f8QDIn/DQmH/0xKpP9XVqn/KymS/yYkkP8mJJD/Ly2U/1taq/9EQaD/CQSF/xURjP+8u97///////f2+/9TUKv/AwCD/xsYjP+fns7/7+73/1lXqv8gHo3/IB6N/2pps//19Pr/jIvE/xQQif8DAIP/X1yw//r6/f/W1ev/Ih6S/wsGhv8hHo7/VFOn/+/u9//JyOP/lZTJ/5WUyf/S0uj/5+fz/0hHof8eG43/BwKF/yomlv/f3+//u7re/xIOi/8QDIj/JSOQ/yookv+op9L/7u72/8jI4//MzOX/7u72/5ybzP8nJZD/JCGP/wwHhv8YE43/x8bk/7q43f8SDYr/EQ2I/yYkkP8lI5D/OTia/2tqs/9TUaf/VlWo/2pps/82NZj/JSOQ/yQij/8MCIf/FxKN/8bF4//S0en/HxuR/wwHhv8kIo//JiSQ/yookv+trNX/5eXy/+bm8v+nptL/KCaR/yYkkP8hHo7/CAOF/ycjlf/c2+7/8/P5/0tIpv8EAIP/HBmM/yclkP8jIY7/ammz//j4/P/39/v/ZmWx/yMhjv8mJJD/FxSK/wMAg/9WU6z/+Pj8//////+lo9P/DAeH/wwIh/8hHo7/JiSQ/zEwlv/JyeP/yMjj/zEvlf8mJJD/HhuN/wkEhf8PC4n/sK/Y////////////9PT6/2Rhs/8EAIT/DAiH/xwZjP8hH47/cnC3/3Nxt/8gHo3/GRaL/woFhv8FAYT/b2y4//j4+//////////////////o5/T/Yl+y/woGh/8EAIP/CweG/xcTi/8WEov/CgaG/wQAg/8NCYj/a2i2/+zs9v////////////////////////////Pz+f+hn9H/RUGk/xsWj/8OCYn/DgmJ/xwYkP9JRqb/p6XU//X1+v////////////////////////////////////////////Dw+P/LyuX/sK7Y/7Gv2f/NzOf/8vL5////////////////////////////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel="icon" type="image/icon" data-savepage-href="favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAABILAAASCwAAAAAAAAAAAAD///////////////////////////n5/P/e3u//yMfk/8nI5P/g3/D/+vr8////////////////////////////////////////////+fn8/7e23P9bWK//KSWW/xgTjv8ZFI7/KyeX/2Bdsf+9u9//+vr9////////////////////////////8PD4/3d1vP8SDor/AwCD/wkEhf8NCYf/DQiH/wgDhf8DAIP/FRGM/4B+wf/08/n/////////////////+fn8/3Vyu/8HA4X/BwOE/xYTiv8iH47/JSKP/yQij/8gHo7/Ew+J/wYBhP8JBYb/gH7B//v7/f///////////7Gw2f8QDIn/DQmH/0xKpP9XVqn/KymS/yYkkP8mJJD/Ly2U/1taq/9EQaD/CQSF/xURjP+8u97///////f2+/9TUKv/AwCD/xsYjP+fns7/7+73/1lXqv8gHo3/IB6N/2pps//19Pr/jIvE/xQQif8DAIP/X1yw//r6/f/W1ev/Ih6S/wsGhv8hHo7/VFOn/+/u9//JyOP/lZTJ/5WUyf/S0uj/5+fz/0hHof8eG43/BwKF/yomlv/f3+//u7re/xIOi/8QDIj/JSOQ/yookv+op9L/7u72/8jI4//MzOX/7u72/5ybzP8nJZD/JCGP/wwHhv8YE43/x8bk/7q43f8SDYr/EQ2I/yYkkP8lI5D/OTia/2tqs/9TUaf/VlWo/2pps/82NZj/JSOQ/yQij/8MCIf/FxKN/8bF4//S0en/HxuR/wwHhv8kIo//JiSQ/yookv+trNX/5eXy/+bm8v+nptL/KCaR/yYkkP8hHo7/CAOF/ycjlf/c2+7/8/P5/0tIpv8EAIP/HBmM/yclkP8jIY7/ammz//j4/P/39/v/ZmWx/yMhjv8mJJD/FxSK/wMAg/9WU6z/+Pj8//////+lo9P/DAeH/wwIh/8hHo7/JiSQ/zEwlv/JyeP/yMjj/zEvlf8mJJD/HhuN/wkEhf8PC4n/sK/Y////////////9PT6/2Rhs/8EAIT/DAiH/xwZjP8hH47/cnC3/3Nxt/8gHo3/GRaL/woFhv8FAYT/b2y4//j4+//////////////////o5/T/Yl+y/woGh/8EAIP/CweG/xcTi/8WEov/CgaG/wQAg/8NCYj/a2i2/+zs9v////////////////////////////Pz+f+hn9H/RUGk/xsWj/8OCYn/DgmJ/xwYkP9JRqb/p6XU//X1+v////////////////////////////////////////////Dw+P/LyuX/sK7Y/7Gv2f/NzOf/8vL5////////////////////////////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">	
<link rel="shortcut icon" type="image/icon" data-savepage-href="favicon.ico" href="data:image/x-icon;base64,AAABAAEAEBAAAAEAIABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAABILAAASCwAAAAAAAAAAAAD///////////////////////////n5/P/e3u//yMfk/8nI5P/g3/D/+vr8////////////////////////////////////////////+fn8/7e23P9bWK//KSWW/xgTjv8ZFI7/KyeX/2Bdsf+9u9//+vr9////////////////////////////8PD4/3d1vP8SDor/AwCD/wkEhf8NCYf/DQiH/wgDhf8DAIP/FRGM/4B+wf/08/n/////////////////+fn8/3Vyu/8HA4X/BwOE/xYTiv8iH47/JSKP/yQij/8gHo7/Ew+J/wYBhP8JBYb/gH7B//v7/f///////////7Gw2f8QDIn/DQmH/0xKpP9XVqn/KymS/yYkkP8mJJD/Ly2U/1taq/9EQaD/CQSF/xURjP+8u97///////f2+/9TUKv/AwCD/xsYjP+fns7/7+73/1lXqv8gHo3/IB6N/2pps//19Pr/jIvE/xQQif8DAIP/X1yw//r6/f/W1ev/Ih6S/wsGhv8hHo7/VFOn/+/u9//JyOP/lZTJ/5WUyf/S0uj/5+fz/0hHof8eG43/BwKF/yomlv/f3+//u7re/xIOi/8QDIj/JSOQ/yookv+op9L/7u72/8jI4//MzOX/7u72/5ybzP8nJZD/JCGP/wwHhv8YE43/x8bk/7q43f8SDYr/EQ2I/yYkkP8lI5D/OTia/2tqs/9TUaf/VlWo/2pps/82NZj/JSOQ/yQij/8MCIf/FxKN/8bF4//S0en/HxuR/wwHhv8kIo//JiSQ/yookv+trNX/5eXy/+bm8v+nptL/KCaR/yYkkP8hHo7/CAOF/ycjlf/c2+7/8/P5/0tIpv8EAIP/HBmM/yclkP8jIY7/ammz//j4/P/39/v/ZmWx/yMhjv8mJJD/FxSK/wMAg/9WU6z/+Pj8//////+lo9P/DAeH/wwIh/8hHo7/JiSQ/zEwlv/JyeP/yMjj/zEvlf8mJJD/HhuN/wkEhf8PC4n/sK/Y////////////9PT6/2Rhs/8EAIT/DAiH/xwZjP8hH47/cnC3/3Nxt/8gHo3/GRaL/woFhv8FAYT/b2y4//j4+//////////////////o5/T/Yl+y/woGh/8EAIP/CweG/xcTi/8WEov/CgaG/wQAg/8NCYj/a2i2/+zs9v////////////////////////////Pz+f+hn9H/RUGk/xsWj/8OCYn/DgmJ/xwYkP9JRqb/p6XU//X1+v////////////////////////////////////////////Dw+P/LyuX/sK7Y/7Gv2f/NzOf/8vL5////////////////////////////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==">
<title>available bankdrops</title>
<style type="text/css">
* { margin: 0; padding: 0; outline:0; }

body {
    font-size: 12px;
    line-height: 18px;
    font-family: arial, sans-serif;
    color: #fff;
    background: #1f2224;
}
	
a, a:visited { color: #fdfdfd; outline: 0; text-decoration: none;
		
		-webkit-transition: all 0.2s linear;
		-moz-transition: all 0.2s linear;
		-ms-transition: all 0.2s linear;
		-o-transition: all 0.2s linear;
		transition: all 0.2s linear;			
	}
	a:hover, a:focus { color: #ED1C24; }
	p a, p a:visited { line-height: inherit; }
	
input, textarea, select { font-family: Arial, Helvetica, sans-serif; font-size:12px; border: 0; }
textarea { overflow:hidden; }

.container { width: 960px; margin: 0 auto; padding: 0;}

.floatimg
{padding-bottom:5px; padding-right:20px;}

h3{color:#ED1C24; font: bold 28px/1em HelveticaNeue, Arial, sans-serif; margin: 0 0 20px 2px; clear:both; padding:0;}

#header{height: 90px; background: url(data:image/gif;base64,R0lGODlhEgBaALMAABkbHRodHh0gIhYYGRseIB0fIR8hIx8iJBUXGAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAASAFoAAARPEMlJq7046827/2AojmRpnmiqrmzrvnAsz3Rt33iu73zv/8CgcEgsGl8DAEFgMAgIgMEFUDhYr9YCgDIIYL/XgBThBZsDCIB5fQAI2GZBBAA7) repeat-x 0 0; }
#header .container { padding: 27px 27px 0 12px; width: 870px; }

#logo {height:34px;width:164px;position:relative;float:left;}

#amenu { position: relative;top: -53px;width: 600px; float: right; display: inline; font-size: 11px; font-family: verdana, arial, sans-serif; line-height: 32px; padding-right: 80px;}
#amenu .menu { list-style: none; }
#amenu .menu li { float: left; padding-left: 6px; }
#amenu .menu li a { text-decoration: none; height: 34px; float: left; display: inline; padding: 24px 8px;}

ul.menu > li > a .bubble{
	font-size:9px;
	line-height:9px;
	padding:1px 4px;
	-webkit-border-radius:3px;
	-moz-border-radius:3px;
	border-radius:3px;
	margin-left:5px;
	position:relative;
	top:0px;
	color:#fff;
	background-color:#d1371c;
	text-shadow:0 1px #032B4F;
}

#cp {
	position:relative;
	padding: 5px 10px;
	top: -33px;
	right: 100px;
	font-size: 10px;
	float:right;
	z-index: 5;
	background-color: rgba(215, 44, 44, 0.6);
	-moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    -khtml-border-radius: 2px;
    border-radius: 2px;
	}
#cp span {padding: 10px;}

#main{
	position: relative;
	top: -20px;
	width: 900px;
	margin: 0 !important;
	padding: 0 40px;
	text-align: left;
}


.txt{
    padding: 0 10px;
    height: 30px;
    background: #fff;
    margin-bottom: 10px;
    border: 1px solid #d1371c;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    border-radius:3px;
    color: #000;
}

.txt.form{text-align: center; padding-left: 0;}

textarea{
	width: auto;
    padding: 10px;
    height: 150px;
    background: #f9f9f9;
    margin-bottom: 10px;
    border: 1px solid #d1371c;
    -moz-border-radius:3px;
    -webkit-border-radius:3px;
    border-radius:3px;
    color: #666;}

.table1 {margin: 20px 0;border-spacing:0;}

.table1 th {
	border: none;
	background: url(data:image/gif;base64,R0lGODlhAgA4ANUAABgbIRMWHCotMQ8RFhUYHhYZHhIVGxseJBIUGhkdIh8hJxIVGg8SFjQ2Ojg6PC8yNi4xNQAAACYpLjM2OTY4OxETGCwuMyMlKyAkKA4RFQ8RFRgbICEkKiUoLSUpLTEzNxsdIzI0OBcaIDU3OisuMi0vNCksMCQmKzk6PTAzNzc5PDk7PhwfJRQXHB0hJg4QFSgqMCAiKBASFxEUGRATGAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4zLWMwMTEgNjYuMTQ1NjYxLCAyMDEyLzAyLzA2LTE0OjU2OjI3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpENEQwQjlCNDZDQ0QxMUUyQjEyMEYxOEI2NDc2RUM4RiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpENEQwQjlCNTZDQ0QxMUUyQjEyMEYxOEI2NDc2RUM4RiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkQ0RDBCOUIyNkNDRDExRTJCMTIwRjE4QjY0NzZFQzhGIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkQ0RDBCOUIzNkNDRDExRTJCMTIwRjE4QjY0NzZFQzhGIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+Af/+/fz7+vn49/b19PPy8fDv7u3s6+rp6Ofm5eTj4uHg397d3Nva2djX1tXU09LR0M/OzczLysnIx8bFxMPCwcC/vr28u7q5uLe2tbSzsrGwr66trKuqqainpqWko6KhoJ+enZybmpmYl5aVlJOSkZCPjo2Mi4qJiIeGhYSDgoGAf359fHt6eXh3dnV0c3JxcG9ubWxramloZ2ZlZGNiYWBfXl1cW1pZWFdWVVRTUlFQT05NTEtKSUhHRkVEQ0JBQD8+PTw7Ojk4NzY1NDMyMTAvLi0sKyopKCcmJSQjIiEgHx4dHBsaGRgXFhUUExIREA8ODQwLCgkIBwYFBAMCAQAAIfkEAAAAAAAsAAAAAAIAOAAABmfA1yuT0WgGAwZDxpTRnrRKZUadIRCLhcEQCLRaBEKhIBJtNgBAIgECHQ4slsulUMRiGAyHc7mcTh0dHh4SEjAwJiYCAiQkFhYlJRAQDw8pKR8fISETEw0NIyMUFCoqDg4oKCsrERFBADs=) top left repeat-x;
	height: 56px;
	text-align: center;
	padding: 0 14px;
	font-size: 14px;
	text-align: left;
	font-weight: 600;
}
.table1 td {
	padding: 8px 14px;
	border: none;

	-webkit-transition: all 0.3s linear;
	-moz-transition: all 0.3s linear;
	-ms-transition: all 0.3s linear;
	-o-transition: all 0.3s linear;
	transition: all 0.3s linear;	
}

.table1 tr:nth-of-type(odd) {
	background: #151718;
}

input.checkb{margin-top:15px;}

hr {border: solid #ddd; border-width: 1px 0 0; clear: both; margin: 10px 0 30px; height: 0;}

.buttn{
	display: inline-block;
	text-decoration: none;
	outline: none;
	cursor: pointer;
	font: bold 14px/1em HelveticaNeue, Arial, sans-serif;
	color: #fff !important;
	padding: 6px 10px;
	border: 1px solid #dedede;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	background: #e6433d;
	background: -webkit-gradient(linear, left top, left bottom, from(#f8674b), to(#d54746));
	background: -moz-linear-gradient(top, #d1371c, #d54746);
	border-color: #d1371c #d1371c #9f220d;
	color: #fff;
	text-shadow: 0 1px 1px #961a07;}

input.buttn,.buttn{
	*width: auto; /* IE7 Fix */
	*overflow: visible; /* IE7 Fix */}

.buttn img {border: none; vertical-align: bottom;}

.buttn:hover, .buttn:focus{
	background: #dd3a37;
	background: -webkit-gradient(linear, left top, left bottom, from(#ff7858), to(#cc3a3b));
	background: -moz-linear-gradient(top, #ff7858, #cc3a3b);
	border-color: #961a07; }
	
.buttn:active{
	background: #e6433d;
	border-color: #961a07;}

.footer {background: #151718 url(data:image/gif;base64,R0lGODlhEgAHALMAAB0fIRseIB8hIx0gIhYYGRodHhkbHRUXGB8iJAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAASAAcAAAQlcKBJq0XD3E3NKdxVHAcBhlNBkKQBcIDHsoQRDIIwBMY6/0BgBAA7) repeat-x 0 top; font-size: 9px; font-family: verdana, arial, sans-serif; color: #8a8b8c; padding-bottom: 15px;}
.footer .container {padding: 22px 25px 0 0; text-align:center;}

.bottom-space {padding:4px 0;}


#checkout
{font-size:40px;}

#warning {font-weight:bold; color:red !important;}
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
<meta name="savepage-url" content="http://z7s2w5vruxbp2wzts3snxs24yggbtdcdj5kp2f6z5gimouyh3wiaf7id.onion/index.php">
<meta name="savepage-title" content="AccMarket - Premium Paypal - Ebay and Bank Accounts">
<meta name="savepage-pubdate" content="Unknown">
<meta name="savepage-from" content="http://z7s2w5vruxbp2wzts3snxs24yggbtdcdj5kp2f6z5gimouyh3wiaf7id.onion/index.php">
<meta name="savepage-date" content="Tue Mar 05 2024 09:34:57 GMT+0200 (Eastern European Standard Time)">
<meta name="savepage-state" content="Standard Items; Retain cross-origin frames; Merge CSS images; Remove unsaved URLs; Load lazy images in existing content; Max frame depth = 5; Max resource size = 50MB; Max resource time = 10s;">
<meta name="savepage-version" content="28.11">
<meta name="savepage-comments" content="">
  </head>
<body>
<div id="header">
	<div class="container">
		
<a  href="index.php"></a><div id="logo"><a   href="cca.php"><img src="assets/logo.png" width="90" height="40"   alt=""></a></div>
	<div id="amenu">
        <ul class="menu">
            <li><a title="Products"  href="cca.php?username=<?=$username?>">Products</a></li>

			<li><a title="Contact Support"   href="gfs.php?username=<?=$username?>">Messages<span class="bubble">1</span></a></li>
			 
		</ul>
	</div>
	</div>
</div>

<div class="container">
<div id="main">





 




 
<br><hr><h3>Available Bankdrops</h3><img data-savepage-currentsrc= "sa1.jpg" data-savepage-src="sa1.jpg" src="sa1.jpg" class="floatimg" style="float:left" width="300" height="100" alt="">Available Banks to choose from 
<br><br>
 Choose a bank from where you want the bankdrops <br><br>


<br><br><table class="table1">
<thead>
<tr>
<th>Banks</th>  
</tr>
</thead>
<tbody>
<tr>
<td> Huntington Bankdrops</td> <td>
<form name="cart" method="post" action="">
    <input value="Huntington" type="hidden" name="bk">
	<input value="300" type="hidden" name="id">
    <input value="add" type="hidden" name="action">
    <input value="100" type="hidden" name="wfprice">
    <input value="offgy logsstore" type="hidden" name="dw">
	<input value="Bank account basic" type="hidden" name="prod">
    <input value="20x random ebay accounts" type="hidden" name="prod">
    <input type="submit" name="submit" class="buttn" value="Select a bank">
</form>
</tr>
<tr>
<td> Chase Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="chase" type="hidden" name="bk">
	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> AFCU Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="AFCU" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> USAA Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="USAA" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> WellsFargo Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="WellsFargo" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> WoodForest Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="WoodForest" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
  <input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> M&T Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="M&T" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> DCU Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="DCU" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> Chime Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="Chime" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> Citi Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="CITI" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> Citizen Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="CITIZEN" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> BOA Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="BOA" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td>Region Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="REGION" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> Capital one Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="CAPITAL ONE" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
<tr>
<td> Cashapp Bankdrops</td>
 <td>
<form name="cart" method="post" action="">
 
<input value="CASHAPP" type="hidden" name="bk">

	<input value="10x Ebay seller accounts with 100+ feedback" type="hidden" name="prod">
	<input type="submit" name="submit" class="buttn" value="Select a bank"></form>
</td>
</tr>
</tbody>
</table>







</div>
</div>
<div class="footer"><div class="container"></div></div>

</body></html>