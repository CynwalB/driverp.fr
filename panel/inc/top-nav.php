<header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">
                    <div class="logo">
                    <a href="<?php echo $url['index']; ?>" class="logo">
                    <span class="logo-small"> DRP </span>
                    <span class="logo-large"> DriveRP </span>
                    </a>
                    </div>
                    <!-- End Logo container-->
                    <div class="menu-extras topbar-custom">
                    <ul class="list-unstyled topbar-right-menu float-right mb-0">
                        <li class="menu-item">
                            <!-- Mobile menu toggle-->
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                                </div>
                            </a>
                            <!-- End mobile menu toggle-->
                        </li>
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                                aria-haspopup="false" aria-expanded="false">
                                <?php
                                if (empty($user['avatar'])) {
                                    echo '<img src="assets/images/users/placeholder.png" alt="user" class="rounded-circle">';
                                } else {
                                    echo '<img src="'. $user['avatar'] .'" alt="user" class="rounded-circle">';
                                }

                                ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <a href="<?php echo $url['settings']; ?>" class="dropdown-item notify-item">
                                <i class="ti-settings m-r-5"></i> Paramètre
                                </a>
                                <!-- item-->
                                <a href="<?php echo $url['logout']; ?>" class="dropdown-item notify-item">
                                <i class="ti-power-off m-r-5"></i> Se déconnecter
                                </a>
                            </div>
                        </li>
                    </ul>
                    </div>
                    <!-- end menu-extras -->
                    <div class="clearfix"></div>
                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                    <!-- Navigation Menu-->
                    <ul class="navigation-menu">
                        <li class="has-submenu">
                            <a href="<?php echo $url['index']; ?>"><i class="mdi mdi-home"></i> <span> Accueil </span> </a>
                        </li>
                        <li class="has-submenu">
                            <a href="<?php echo $url['civilian']; ?>?v=nosession"><i class="mdi mdi-contacts"></i> <span> Civil </span> </a>
                        </li>
                        <li class="has-submenu">
                            <a href="<?php echo $url['leo']; ?>?v=nosession"><i class="mdi mdi-pistol"></i> <span> LSPD </span> </a>
                        </li>
                        <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-heart-pulse"></i> <span> SAMS </span> </a>
                        </li>
                        <li class="has-submenu">
                            <a href="dispatch.php?v=nosession"><i class="mdi mdi-phone-in-talk"></i> <span> Dispatch </span> </a>
                        </li>
                        <?php if (staff_access === 'true'): ?>
                          <li class="has-submenu">
                            <a href="#"><i class="mdi mdi-file-lock"></i><span> Staff </span></a>
                              <?php if (staff_access === 'true'): ?>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                            <a href="<?php echo $url['staff']; ?>?m=settings">Paramètres</a>
                                        <ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <a href="<?php echo $url['staff']; ?>?m=users">Utilisateurs</a>
                                        <ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <a href="<?php echo $url['staff']; ?>?m=pending-users">Attente de validation</a>
                                        <ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <a href="<?php echo $url['staff']; ?>?m=usergroups">Groupes</a>
                                        <ul>
                                    </li>
                                </ul>
                              <?php endif; ?>
                          </li>
                        <?php endif; ?>
                    </ul>
                    <!-- End navigation menu -->
                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->
        </header>
