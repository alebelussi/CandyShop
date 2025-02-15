<?php

    class MenuManager {

        public $menu;
        public static function generateMenu($ruolo) {
            $menu = '
                <nav>
                <div class="navbar">
                    <div class = "logo">
                        <img src="../Immagini/logoCandyshop.png" alt="logo"  class="logo-img">
                    </div>
                    <ul class="menu">
                        <li class="menu-item"><a href="homePage.php">Home</a></li>';
             
            if(!($ruolo === "")){
                if ($ruolo === 'Amministratore') {
                    $menu .= '
                        <li class="menu-item dropdown"> Prodotti
                            <ul class="dropdown-menu">
                                <li><a href="addProduct.php">Aggiungi</a></li>
                                <li><a href="viewProduct.php">Visualizza</a></li>
                            </ul>
                        </li>
                        <li class="menu-item dropdown"> Clienti
                            <ul class="dropdown-menu">
                                <li><a href="register.php">Aggiungi</a></li>
                                <li><a href="viewUser.php">Visualizza</a></li>
                                <li><a href="viewReport.php">Report</a></li>
                            </ul>
                        </li>';
                    
                }
                else {
                    $menu .= '
                        <li class="menu-item dropdown">Prodotti
                            <ul class="dropdown-menu">
                                <li><a href="viewProduct.php">Visualizza</a></li>
                            </ul>
                        </li>';
                }
                $menu .= '
                    <li class="menu-item dropdown">Ordini
                        <ul class="dropdown-menu">
                            <li><a href="viewOrder.php">Visualizza</a></li>
                        </ul>
                    </li>
                    <li><a href="carrelloPage.php"><i class="fas fa-shopping-cart" style="margin-top: 13px"></i></a></li>';
            }
            else 
                $menu .= '<li class="menu-item"><a href="login.html"><i class="fas fa-user"></i></a></li>';
                       
            $menu .= '<li class="menu-item"><a href="logout.php"><i class="fas fa-sign-out"></i></a></li>
                        </ul>
                    </div>
                    </nav>';
            return $menu;
        }
    }
?>