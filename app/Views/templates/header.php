<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>" class="csrf">
    <title><?= $title; ?></title>
    <base href="/user/">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

      <link rel="stylesheet" href="assets/css/style.css">
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
      
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
  </head>
  <body>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
	    <div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		  <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> 
          </button>
		  <a class="navbar-brand" href="<?= route_to('home'); ?>">The Wardrobe</a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
	  <ul class="nav navbar-nav">
      <li><a href="<?= route_to('home'); ?>">Home</a></li>
      <li><a href="#">New Arrivals</a></li>
		  <li><a href="#">Sale</a></li>
		  <li><a href="#">Women</a></li>
      <li><a href="#">Men</a></li>
		  <li><a href="#">Kids</a></li>
      <li><a href="#">Pet</a></li>
	  </ul> 
	  <ul class="nav navbar-nav navbar-right">
		  <li><a href="#"><span class="glyphicon glyphicon-envelope"></span> Contact Us</a></li>
      <li><a href="#"><span class="glyphicon glyphicon-shopping-cart"></span></a></li>
      <?php  if(!session()->has('loggedUser')) : ?>
		  <li><a href="<?= route_to('login'); ?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      <?php  endif; ?>
      <?php  if(session()->has('loggedUser')) : ?>
      <li><a href="<?= route_to('profile'); ?>"><span class="glyphicon glyphicon-user"></span> <?= $userInfo['first_name'] ?></a></li>
        <?php  endif; ?>
        <?php  if(session()->has('loggedUser')) : ?>
        <li><a href='<?=route_to('logout'); ?>'><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <?php  endif; ?>
	  </ul>            
	  <form class="navbar-form navbar-right">
	     <div class="form-group">
		     <input type="text" class="form-control" placeholder="Search">
		 </div>
		 <button type="submit" class="btn"><span class="glyphicon glyphicon-search"></span>
     </button>
          </form>
    </div>  
   </div>  
        </nav>
