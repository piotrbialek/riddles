<header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-list">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Riddles</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-list">
                <?php
                if (!isset($_SESSION['logged'])) {
                    echo '<span class="pull-right"><a href="../../projekt/index.php">Log in</a> or <a href="../../projekt/registration.php">Sign up</a></span>';
                } else { ?>
                    <ul class="nav navbar-nav navbar-right navbar-user">
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <span><i class="glyphicon glyphicon-user"></i></span>
                                <?php echo $_SESSION['login'] ?>(<?php echo $_SESSION['player_level'] ?>) <span
                                        class="caret"></span></a>

                            <ul class="dropdown-menu">
                                <li><a href="../../projekt/game.php"><span><i
                                                    class="glyphicon glyphicon-play"></i></span> Single-player</a></li>
                                <li><a href="#"><span><i class="glyphicon glyphicon-globe"></i></span> Multi-player</a>
                                </li>
                                <li><a href="../../projekt/myRiddles.php"><i
                                                class="glyphicon glyphicon-home"></i></span> My riddles</a></li>
                                <li><a href="../../projekt/add.php"><span><i class="glyphicon glyphicon-plus-sign"></i></span>
                                        Add riddle</a></li>

                                <?php
                                $admin = $_SESSION['admin'];
                                if ($admin == 1) { ?>
                                    <li class="divider"></li>
                                    <li><a href="../../projekt/admin/riddles.php"><span><i
                                                        class="glyphicon glyphicon-th-list"></i></span> All riddles</a>
                                    </li>
                                    <li><a href="../../projekt/admin/users.php"><span><i
                                                        class="glyphicon glyphicon-list"></i></span> All users</a></li>
                                <?php } ?>

                                <li class="divider"></li>
                                <li><a href="../../projekt/logout.php"><span><i class="glyphicon glyphicon-log-out"></i></span>
                                        Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>
