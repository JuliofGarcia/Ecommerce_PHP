<!-- Navbar -->

<div class="container py-2 py-lg-4">

  <div class="row">

    <div class="col-12 col-lg-2 mt-1">

      <div class="d-flex justify-content-center">
        <a href="<?php echo $path ?>" class="navbar-brand">
          <img src="<?php echo $path ?>views/assets/img/template/<?php echo $template->id_template ?> /<?php echo $template->logo_template ?>" alt="Logo Cielo Rosa" class="brand-image img-fluid rounded-circle py-2 px-5 p-lg-0 pe-lg-3">
        </a>
      </div>

    </div>

    <div class="col-12 col-lg-7 col-xl-8 mt-1 px-3 px-lg-0">


      <?php if (isset($_SESSION["admin"])) : ?>
        <a class="nav-link float-start me-2" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>


      <?php endif ?>




      <div class="dropdown px-3 py-2 float-start templateColor">

        <a id="dropdownSubMenu1" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle text-uppercase">
          <span class="d-lg-block d-none"> Categorias <i class="ps-lg-2 fas fa-th-list"></i></span>
          <span class="d-lg-none d-block"><i class="fas fa-th-list"></i></span>
        </a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">

          <!-- Level two dropdown-->

          <li class="dropdown-submenu dropdown-hover">

            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle text-uppercase">

              <i class="fas fa-shoe-prints pe-2 fa-xs"></i> calzado
            </a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
              <li>
                <a tabindex="-1" href="#" class="dropdown-item text-uppercase">calzado para dama</a>
              </li>
              <li>
                <a tabindex="-1" href="#" class="dropdown-item text-uppercase">calzado para hombre</a>
              </li>
              <li>
                <a tabindex="-1" href="#" class="dropdown-item text-uppercase">calzado para deportiva</a>
              </li>
            </ul>
          </li>

          <li class="dropdown-submenu dropdown-hover">

            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle text-uppercase">

              <i class="fas fa-shoe-prints pe-2 fa-xs"></i> ropa
            </a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
              <li>
                <a tabindex="-1" href="#" class="dropdown-item text-uppercase">ropa para dama</a>
              </li>
              <li>
                <a tabindex="-1" href="#" class="dropdown-item text-uppercase">ropa para hombre</a>
              </li>
              <li>
                <a tabindex="-1" href="#" class="dropdown-item text-uppercase">ropa para deportiva</a>
              </li>
            </ul>
          </li>
          <li class="dropdown-submenu dropdown-hover">
            <div class="accordion-item d-block d-lg-none ">
              <div class="accordion-header" id="accordionExample">
                <a id="dropdownSubMenu2 headingTwo" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle text-uppercase" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseTwo">
                  <i class="fas fa-shoe-prints pe-2 fa-xs"></i> ropa

              </div>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <ul class="border-0 shadow">
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">ropa para dama</a>
                    </li>
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">ropa para hombre</a>
                    </li>
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">ropa para deportiva</a>
                    </li>
                  </ul>

                  <!-- End Level two -->

                </div>
              </div>
            </div>
          </li>
          <li class="dropdown-submenu dropdown-hover">
            <div class="accordion-item d-block d-lg-none ">
              <div class="accordion-header">
                <a id="dropdownSubMenu2 heading3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle text-uppercase" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-controls="collapse3">
                  <i class="fas fa-shoe-prints pe-2 fa-xs"></i> Juguetes

              </div>
              <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <ul class="border-0 shadow">
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">Juguetes para dama</a>
                    </li>
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">Juguetes para hombre</a>
                    </li>
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">Juguetes para deportiva</a>
                    </li>
                  </ul>

                  <!-- End Level 3 -->

                </div>
              </div>
            </div>
          </li>

          <li class="dropdown-submenu dropdown-hover">
            <div class="accordion-item d-block d-lg-none ">
              <div class="accordion-header">
                <a id="dropdownSubMenu2 heading4" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle text-uppercase" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-controls="collapse4">
                  <i class="fas fa-shoe-prints pe-2 fa-xs"></i> Tecnologia

              </div>
              <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  <ul class="border-0 shadow">
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">Tecnologia para dama</a>
                    </li>
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">Tecnologia para hombre</a>
                    </li>
                    <li>
                      <a tabindex="-1" href="#" class="dropdown-item text-uppercase">Tecnologia para deportiva</a>
                    </li>
                  </ul>

                  <!-- End Level 3 -->

                </div>
              </div>
            </div>
          </li>
          <!-- End Level two -->
        </ul>
      </div>
      <!-- SEARCH FORM -->
      <form class="form-inline">
        <div class="input-group input-group w-100 me-0 me-lg-4">
          <input class="form-control rounded-0 p-3 pe-5" type="search" placeholder="Buscar" style="height: 40px;">
          <div class="input-group-append px-2 templateColor">
            <button class="btn btn-navbar text-white" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

    </div>

    <div class="col-12 col-lg-3 col-xl-2 mt-1 px-3 px-lg-0">
      <div class="my-2 my-lg-0 d-flex justify-content-center">
        <a href="#">
          <button class="bt btn-default float-start rounded-0 border-0 py-2 px-3 templateColor">
            <i class="fa fa-shopping-cart"></i>
          </button>
        </a>
        <div class="small border float-start ps-2 pe-4 w-100 text-uppercase">

          tu cesta <span> 0 </span>usd $<span> 0 </span>
        </div>
      </div>
    </div>

  </div>

</div>
<!-- /.navbar -->