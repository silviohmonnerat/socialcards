<header class="App-header">
    <section id="desktop-menu" class="desktop-menu">
        <nav class="sidebar flex-column-nowrap">
            <a class="sidebar__logo" href="/">
                <abbr class="logo">SC</abbr>
            </a>
            <ul class="sidebar__nav-list flex-column-nowrap" role="menubar" aria-label="Main desktop menu">
                <li class="nav-list__item home active fake-button flex-column-nowrap" role="menuitem">
                    <a class="flex-row-wrap" href="/" tabindex="0" data-target="link">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span class="u-uppercase">Home</span>
                    </a>
                </li>	
                <li class="nav-list__item sobre fake-button flex-column-nowrap" role="menuitem">
                    <a class="flex-row-wrap" href="/sobre" tabindex="0" data-target="link">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                        <span class="u-uppercase">Sobre</span>
                    </a>
                </li>
                <li class="nav-list__item categorias fake-button flex-column-nowrap" role="menuitem">
                    <a href="javascript:void(0);" class="flex-row-wrap" tabindex="0">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <span class="u-uppercase">Categorias</span>
                    </a>
                    <ul class="nav-list__item-selector flex-column-nowrap" aria-label="submenu" aria-hidden="true" aria-expanded="false" aria-haspopup="true">
                    </ul>
                </li>
                <li class="nav-list__item contato fake-button flex-column-nowrap" role="menuitem" style="display:none;">
                    <a class="flex-row-wrap" href="/contato" tabindex="0" data-target="link">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span class="u-uppercase">Contato</span>
                    </a>
                </li>
            </ul>
            <ul class="sidebar__extra-content" role="menu">
                <li class="extra-content__share criar fake-button flex-row-wrap" role="menuitem">
                    <a href="javascript:void(0);" tabindex="0" data-target="modal" data-animate="two">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <span class="u-uppercase">Filtro</span>
                    </a>
                </li>	
                <li class="extra-content__share criar fake-button flex-row-wrap" role="menuitem">
                    <a href="javascript:void(0);" tabindex="0" data-target="criar">
                        <i class="fa fa-plus-circle"></i>
                        <span class="u-uppercase">Criar</span>
                    </a>
                </li>
            </ul>
        </nav>
    </section>

    <section id="mobile-menu" class="mobile-menu navbar flex-row-wrap">
        <a class="navbar__logo" href="/">
            <span class="logo">SC</span>
        </a>
        <div class="navbar__mobile-menu">
            <div class="menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <nav class="navbar__mobile-menu__nav" aria-label="Main mobile menu" aria-hidden="true">
            <ul class="navbar__mobile-menu__list flex-column-nowrap" role="menu">
                <li class="navbar__mobile-menu__item flex-row-wrap about-me u-uppercase fake-button active" role="menuitem">
                    <a href="/sobre" tabindex="-1">Sobre</a>
                </li>
                <li class="navbar__mobile-menu__item flex-row-wrap language u-uppercase fake-button" role="menuitem" aria-haspopup="true" aria-expanded="false">
                    <a class="flex-row-nowrap">
                        <span>Categorias</span>
                        <svg class="arrow-icon" height="17.021526" width="9.999999" viewBox="0 0 9.6094522 16.356756"><g transform="matrix(0.03324517,0,0,0.03324517,-3.3736534,0)" id="g6"><path style="fill:#c6c6c6" id="path2" d="M 382.678,226.804 163.73,7.86 C 158.666,2.792 151.906,0 144.698,0 137.49,0 130.73,2.792 125.666,7.86 l -16.124,16.12 c -10.492,10.504 -10.492,27.576 0,38.064 L 293.398,245.9 109.338,429.96 c -5.064,5.068 -7.86,11.824 -7.86,19.028 0,7.212 2.796,13.968 7.86,19.04 l 16.124,16.116 c 5.068,5.068 11.824,7.86 19.032,7.86 7.208,0 13.968,-2.792 19.032,-7.86 L 382.678,265 c 5.076,-5.084 7.864,-11.872 7.848,-19.088 0.016,-7.244 -2.772,-14.028 -7.848,-19.108 z"></path></g></svg>
                    </a>
                    <ul class="language__list flex-row-nowrap" role="submenu" aria-hidden="true" aria-expanded="false">
                        <li class="language__item ca" role="menuitem">
                            <a class="flex-row-nowrap" href="/?categoria=1" tabindex="-2">
                                <span>BBB19</span>
                            </a>
                        </li>
                        <li class="language__item es" role="menuitem">
                            <a class="flex-row-nowrap" href="/?categoria=2" tabindex="-2">
                                <span>Séries</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="navbar__mobile-menu__item flex-row-wrap contact u-uppercase fake-button" role="menuitem">
                    <a href="/contato" tabindex="-1">Contato</a>
                </li>
            </ul>
        </nav>
    </section>
</header>

<div id="modal-container">
    <div class="modal-background">
        <form action="/">
            <div class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Filtrar</h5>
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="search" name="s" id="s" placeholder="Pesquisar ..." />
                    </div>
                    <div class="modal-footer">
                        <hr />
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>