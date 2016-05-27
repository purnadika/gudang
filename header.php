<html>
<head>
<link rel=”icon” type=”image/png” href=”Preloader_3.gif”>
<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap-theme.min.css">
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
 <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
--><script stype="text/javascript" src="css/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="css/bootstrap.min.js"></script>
<script type="text/javascript" src="css/list.min.js"></script>
 <style>
        canvas{border: 0px solid #bbb;}
        .subdiv{width: 800px;}
        .text{margin: auto; width: 290px;}
    </style>
 <script type="text/javascript">
        var can, ctx, step, steps = 0,
              delay = 15;
 
        function init() {
		var judul =document.title;
            can = document.getElementById("MyCanvas1");
            ctx = can.getContext("2d");
            ctx.fillStyle = "black";
            ctx.font = "20pt Britanic Bold";
            ctx.textAlign = "right";
            ctx.textBaseline = "middle";
            step = 0;
            steps = can.width + 10;
            RunTextLeftToRight();
        }
 
        function RunTextLeftToRight() {
		var judul =document.title;
            step++;
            ctx.clearRect(0, 0, can.width, can.height);
            ctx.save();
            ctx.translate(step, can.height / 2);
            ctx.fillText("                                                                                         " + judul, 0, 0);
            ctx.restore();
            if (step == steps)
                step = 2;
            if (step < steps)
                var t = setTimeout('RunTextLeftToRight()', delay);
        }
    </script>
 
</head>
<body style="padding-top:60px; padding-left:10px; padding-right:10px" onload="init();">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img style="max-width:50px; margin-top: -15px;"
             src="logo.png"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
	
        <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
        <li><a href="pesan.php">Pemesanan</a></li>
		<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gudang <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="barang.php">Master Barang</a></li>
           <li role="separator" class="divider"></li>
            <li><a href="transaksi.php">Transaksi</a></li>
          </ul>
        </li>
      </ul>
     <p class="navbar-text">
	
        <canvas id="MyCanvas1" width="800" height="20">
  This browser or document mode doesn't support canvas object</canvas>
   
	 </p>
	 
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</body>
</html>