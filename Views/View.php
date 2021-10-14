<?php

namespace thesystem\Views;

class View{
    private $sys;
    public function __construct($sys=null){
        $this->sys = $sys;
    }
    public function __destruct(){

    }

    public function render(){
        
        $this->render_head();
        $this->render_nav();
        $this->render_body();
        $this->render_foot();
    }

    private function render_head(){
        ?><html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
        <?php
    }

    private function render_nav(){
        ?>
        <header>
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">No One Logged In</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <?php if($this->sys->currentUser()):?>
                <li class="nav-item">
                    Logged in:  <?php echo $usys->currentUser()->name();?>
                </li>
            <?php else:?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/signup">Sign Up</a>
                    </li>
                <?php endif;?>
        </ul>
      </div>
    </div>
  </nav>
</header>

        <?php
    }

    protected function render_body(){
        ?>
        <div class="container">
        </div>
        <?php
    }

    private function render_foot(){
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php

    }
}