<!DOCTYPE html>
<html>

  <head>
    <title>
      <?= isset($title) ? $title : 'My great website' ?>
    </title> 
    <meta charset="utf-8" />  
    <link rel="stylesheet" href="/css/Envision.css" type="text/css" />
  </head>
  

  <body>
    <div id="wrap">
      <header>
        <h1><a href="/">Admin Area</a></h1>
      </header>
      
      <nav>
        <ul>
          <li><a href="/">Home</a></li>
          <?php if ($user->isAuthenticated()) : ?>
          <li><a href="/admin/">Admin</a></li>
          <li><a href="/admin/news-insert.html">Insert a news</a></li>
          <li><a href="/admin/news-delete.html">Delete a news</a></li>
          <li><a href="/admin/disconnect.html">Disconnect</a></li>
          <?php endif; ?>
        </ul>
      </nav>
      
      <div id="content-wrap">
        <section id="main">
          <?php if ($user->hasFlash()) {echo '<p style="text-align: center;">', $user->getFlash(), '</p>';} ?>          
          <?= $content ?>
        </section>
      </div>
    
      <footer></footer>
    </div>
  </body>
  
</html>