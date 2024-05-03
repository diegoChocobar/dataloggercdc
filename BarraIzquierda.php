
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
                <a id="linkIndicadores" href="Indicacores.php">
                  <span class="nav-icon">
                    <i class="fa fa-navicon"></i>
                  </span>
                  <span class="nav-text">Indicadores</span>
                </a>
              </li>

              <li>
                <a id="linkDevices" href="devices.php">
                  <span class="nav-icon">
                    <i class="fa fa-cogs"></i>
                  </span>
                  <span class="nav-text">Dispositivos</span>
                </a>
              </li>

              <li>
                <a id="linkFunciones" href="Funciones.php">
                  <span class="nav-icon">
                    <i class="fa fa-cogs"></i>
                  </span>
                  <span class="nav-text">Funciones</span>
                </a>
              </li>

            </ul>
          </nav>
        </div>
      </div>
    </div>
    <!-- / -->
