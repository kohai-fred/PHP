<header class="sticky-top">
        <div class="navbar navbar-expand-lg navbar-light ">
            <!--  Search Full Screen  -->
            <div id="myOverlay" class="overlay">
                
                <span class="closebtn" onclick="closeSearch()" title="Close Overlay">x</span>
                <div class="overlay-content">
                    <form action="action_page.php">
                        <input id="searchInputBar" type="text" placeholder="Search.." name="search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <div id="divh"><p id="h"></p></div>
            </div>
            <!-- FIN -->
            <div class="container">
                <div class="container-fluid">
                    <div class="d-flex align-items-center box-header-un">

                        <div class=" col-lg-4">
                            <a href="index.php"><img class="logo-header" src="img/Hellociné_2.png"alt="logo de Hellocine"></a>
                                    
                        </div>

                        <!-- Box Évenement Tablette -->
                        <div class="d-none d-lg-block col-lg-8 marquee-rtl">

                            <div class="container info">La <span class="evt">Fête du Cinéma</span> aura lieu les dimanche
                                <span class="evt">28</span>, lundi <span class="evt">29</span>, mardi <span
                                    class="evt">30</span> juin et mercredi <span class="evt">1er</span> juillet 2020 dans
                                tous les cinémas participants.
                            </div>

                        </div>

                        <div >
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>

                    </div>

                    <div class="collapse navbar-collapse text-center" id="navbarNavDropdown">
                        <nav class="navbar-nav container-fluid justify-content-between align-items-center">

                            <a href="index.php"class="order-2 order-lg-1">Accueil</a>
                            <a href="index.html#prochainement"class="order-3 order-lg-2">Prochainement</a>
                            <a href="equipededeveloppement.html"class="order-4 order-lg-3">L'équipe de développement</a>

                            <div class="row justify-content-between item-nav order-lg-4">
                                <div>
                                    <i class="fas fa-search"></i>
                                </div>
                                <div>
                                    <a data-toggle="modal" data-target="#exampleModal"data-whatever="@mdo"><i class="far fa-user"></i></a>
                                </div>
                            </div>

                        </nav>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>
