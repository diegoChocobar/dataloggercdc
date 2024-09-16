
    <!-- BARRA IZQUIERDA -->
    <!-- aside -->
    <div id="aside" class="app-aside modal nav-dropdown">
      <!-- fluid app aside -->
      <div class="left navside dark dk" data-layout="column">
        <div class="navbar no-radius">
          <!-- brand -->
          <a class="navbar-brand">
            <div ui-include="'assets/images/logo.svg'"></div>
            <img src="assets/images/logo.png" alt="." class="hide">
            <span class="hidden-folded inline">CdC Electronics</span>
          </a>
          <!-- / brand -->
        </div>
        <div class="hide-scroll" data-flex>
          <nav class="scroll nav-light">

            <ul class="nav" ui-nav>
              <li class="nav-header hidden-folded">
                <small class="text-muted">Main</small>
              </li>

              <li>
                <a id="linkPrincipal" href="dashboard.php">
                  <span class="nav-icon">
                    <i class="fa fa-building-o"></i>
                  </span>
                  <span class="nav-text">Principal</span>
                </a>
              </li>

              <li>
                <a>
                  <span class="nav-icon">
                    <i class="fa fa-navicon"></i>
                  </span>
                  <span class="nav-text">Sensores</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a id="linkSensorsTemp" href="sensorstemperatura.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Sensores Temperatura</span>
                    </a>
                    <a id="linkSensorsPresion" href="sensorspresion.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Sensores Presion</span>
                    </a>
                    <a id="linkSensorsCaudal" href="sensorscaudal.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Sensores Caudal</span>
                    </a>
                    <a id="linkSensorsHumedad" href="sensorshumedad.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Sensores Humedad</span>
                    </a>
                    <a id="linkSensorsGas" href="sensorsgas.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Sensores Gas</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li>
                <a>
                  <span class="nav-icon">
                    <i class="fa fa-navicon"></i>
                  </span>
                  <span class="nav-text">Contactor</span>
                </a>
                <ul class="nav-sub">
                  <li>
                    <a id="linkContactorLuz" href="contactorluz.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Contactor Luz</span>
                    </a>
                    <a id="linkContactorPotencia" href="contactorpotencia.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Contactor Potencia</span>
                    </a>
                    <a id="linkContactorBomba" href="contactorbomba.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Contactor Bomba</span>
                    </a>
                    <a id="linkContactorValvula" href="contactorvalvula.php" onclick>
                      <span class="nav-icon"><i class="fa fa-bar-chart-o"></i></span>
                      <span class="nav-text">Contactor Valvula</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li>
                <a id="linkDevices" href="devices.php">
                  <span class="nav-icon">
                    <i class="fa fa-cogs"></i>
                  </span>
                  <span class="nav-text">Dispositivos</span>
                </a>
              </li>

              <!--li>
                <a id="linkFunciones" href="Funciones.php">
                  <span class="nav-icon">
                    <i class="fa fa-cogs"></i>
                  </span>
                  <span class="nav-text">Funciones</span>
                </a>
              </li-->

            </ul>
          </nav>
        </div>

      <div class="b-t">
        <div class="nav-fold">
          <a href="dashboard.php">
            <span class="pull-left">
              <img src="assets/images/a5.jpg" alt="..." class="w-40 img-circle">
            </span>
            <span class="clear hidden-folded p-x">
              <span class="block _500"><?php echo $_SESSION['users_name'] ?></span>
              <small class="block text-muted"><i class="fa fa-circle text-success m-r-sm"></i>online</small>
            </span>
          </a>
        </div>
      </div>

      </div>
    </div>
    <!-- / -->
