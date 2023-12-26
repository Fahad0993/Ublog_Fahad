<header>
        <a href="<?php echo BASE_URL . '/index.php';?>" class="logo">
            <h1 class="logo-text"><span>U</span>Blog</h1>
        </a>
        <i class="fa fa-bars menu-toggle"></i>
        <ul class="nav">
            <li><a href="<?php echo BASE_URL . '/index.php';?>">Home</a></li>
            <?php if(isset($_SESSION['id'])):?>
                <li>
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <?php echo $_SESSION['username']; ?>
                        <i class="fa fa-chevron-down" style="font-size: 0.8em;"></i>
                    </a>
                    <ul>
                        <?php if($_SESSION['role']==1):?>
                            <li><a href="<?php echo BASE_URL . '/admin/dashboard.php';?>">Dashboard</a></li>
                        <?php elseif($_SESSION['role']==2):?>
                            <li><a href="<?php echo BASE_URL . '/category_admin/dashboard.php';?>">Dashboard</a></li>
                        <?php elseif($_SESSION['role']==3):?>
                            <li><a href="<?php echo BASE_URL . '/blogger/dashboard.php';?>">Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo BASE_URL . '/logout.php';?>" class="logout">Logout</a></li>
                    </ul>
                </li>
            <?php else:?>
                <li><a href="<?php echo BASE_URL . '/register.php';?>">Sign-up</a></li>
                <li><a href="<?php echo BASE_URL . '/login.php';?>">Login</a></li>
            <?php endif;?>
        </ul>
    </header>