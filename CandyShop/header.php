<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <?php
        //session_start();
        //$ruolo = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Cliente';
        session_start();
        $ruolo = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : "";
        require "Menu/menuManager.php";
        echo MenuManager::generateMenu($ruolo);
    ?>
</header>