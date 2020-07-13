<?php
$file = $_GET['file']
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/main.css">
    <script type='text/javascript' src='https://cdn.scaledrone.com/scaledrone.min.js'></script>
</head>
<body>
  <div class="full-window">
      <nav class="navbar navbar-expand-lg ">
          <a class="navbar-brand"><img class="logo" src="../../images/logo.PNG" alt="" srcset=""></a>
          <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div id="my-nav" class="collapse navbar-collapse">
              <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                      <a class="nav-link" href="#"><h4>Logout</h4></a>
                  </li>
                  
              </ul>
          </div>
      </nav>
      <div class="virtual bg-grey pt-5 pb-5">
        <section class="container  row">
        <div class="col-md-6">
                <video id="remoteVideo" autoplay muted></video>
            </div>
            <div class="col-md-6 pl-5">
             <iframe class="material" src="<?php echo $file; ?>" frameborder="0"></iframe>
            </div>
           </section>
           <section class="container pt-2 d-flex justify-content-between">
            <div id="participantsContainer" class="col-md-4 bg-light">
             
            </div>
            <div class="col-md-7">
                <div class="card p-2">
                    <h5 class="text-info">Chat</h5>
                   <textarea id="responsecontainer" class="" name="" id="" cols="35" rows="7 " disabled> 
                   </textarea> 
                  <form id="chatForm" onsubmit="return false">
                      <input type="text" id="message" name="message" class="col-md-10">
                      <button type="button" id="btn-msg" class="btn btn-success">Send</button>
                  </form>
                  
                </div>
                
     
                
            </div>
           </section>
      </div>
      
    
  </div>

<script src="../../js/jquery.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/studentVirtualClass.js"></script>
<script src="../../js/script.js"></script>
</body>
</html>