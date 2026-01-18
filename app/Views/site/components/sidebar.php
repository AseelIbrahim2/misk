<!-- components/sidebar.php -->

<aside class="sidebar bg-primary d-flex flex-column" id="mainSidebar">

  <!-- Sidebar Header -->
  <div class="d-flex justify-content-between align-items-center px-5 py-4">
    <div class="logo-img1">
      <img src="/assets/images/logo-colored.svg" class="img-fluid" alt="Logo">
    </div>

    <button class="btn-close-custom" id="sidebarClose" aria-label="Close menu">
      <svg width="50" height="50" viewBox="0 0 24 24"
           fill="none" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
  </div>

  <!-- Sidebar Menu -->
  <div class="sidebar-content px-5">
    <ul class="list-unstyled menu-list">

      <!-- About -->
      <li class="menu-item">
        <a href="#" class="menu-link collapsed"
           data-bs-toggle="collapse"
           data-bs-target="#about-us">
          About Us
        </a>

        <div class="collapse" id="about-us">
          <ul class="list-unstyled submenu-list ps-3">
            <li><a href="#" class="submenu-link">Director General Welcome</a></li>
            <li><a href="#" class="submenu-link">Mission, Vision & Values</a></li>
            <li><a href="#" class="submenu-link">Vision 2023</a></li>
            <li><a href="#" class="submenu-link">Student Leaders</a></li>
            <li><a href="#" class="submenu-link">Campus</a></li>
            <li><a href="#" class="submenu-link">School Leaders & Governance</a></li>
            <li><a href="#" class="submenu-link">Our Policies</a></li>
            <li><a href="#" class="submenu-link">MMISK Schools Academy</a></li>
            <li><a href="#" class="submenu-link">MISK Foundation</a></li>
            <li><a href="#" class="submenu-link">News & Gallery</a></li>
            <li><a href="#" class="submenu-link">Media Center</a></li>
          </ul>
        </div>
      </li>

    <!-- Admissions -->
        <li class="menu-item">
          <a href="#"
             class="menu-link d-flex align-items-center collapsed"
             data-bs-toggle="collapse"
             data-bs-target="#submenu-admissions">
            Admissions
            <span class="arrow-icon ms-2">▼</span>
          </a>

          <div class="collapse" id="submenu-admissions">
            <ul class="list-unstyled submenu-list ps-3">
              <li><a href="#" class="submenu-link">Admissions Process</a></li>
              <li><a href="#" class="submenu-link">Admission Fees</a></li>
              <li><a href="#" class="submenu-link">Term Dates & FAQ's</a></li>
            </ul>
          </div>
        </li>

        <!-- Learning Journey -->
        <li class="menu-item">
          <a href="#"
             class="menu-link d-flex align-items-center collapsed"
             data-bs-toggle="collapse"
             data-bs-target="#submenu-learning">
            Learning Journey
            <span class="arrow-icon ms-2">▼</span>
          </a>

          <div class="collapse" id="submenu-learning">
            <ul class="list-unstyled submenu-list ps-3">

              <li>
                <a href="#"
                   class="submenu-link d-flex align-items-center collapsed"
                   data-bs-toggle="collapse"
                   data-bs-target="#nested-curriculum">
                  Academic Curriculum
                  <span class="arrow-icon ms-2">▼</span>
                </a>

                <div class="collapse" id="nested-curriculum">
                  <ul class="list-unstyled nested-submenu-list ps-3">
                    <li><a href="#" class="nested-link">Kindergarten</a></li>
                    <li><a href="#" class="nested-link">Lower Primary</a></li>
                    <li><a href="#" class="nested-link">Upper Primary</a></li>
                    <li><a href="#" class="nested-link">Senior Schools</a></li>
                  </ul>
                </div>
              </li>

              <li><a href="#" class="submenu-link">MISK Schools Diploma</a></li>
              <li><a href="#" class="submenu-link">High Performance Learning</a></li>
              <li><a href="#" class="submenu-link">Leadership & Critical Thinking</a></li>
              <li><a href="#" class="submenu-link">Internship & Service Ethics</a></li>
              <li><a href="#" class="submenu-link">Project 10: Becoming one of the World's Top 10 Schools</a></li>
              <li>
              <a href="#" class="submenu-link d-flex align-items-center ">
                Co-Curricular Activities
                <span class="arrow-icon ms-2">▼</span>
              </a>
            </li>

            <li>
              <a href="#" class="submenu-link d-flex align-items-center">
                Safeguarding & Wellbeing
                <span class="arrow-icon ms-2">▼</span>
              </a>
            </li>
            </ul>
          </div>
        </li>

        <!-- Work With Us -->
        <li class="menu-item">
          <a href="#"
             class="menu-link d-flex align-items-center collapsed"
             data-bs-toggle="collapse"
             data-bs-target="#submenu-work">
            Work With Us
            <span class="arrow-icon ms-2">▼</span>
          </a>

          <div class="collapse" id="submenu-work">
            <ul class="list-unstyled submenu-list ps-3">
              <li><a href="#" class="submenu-link">Why Join Us?</a></li>
              <li><a href="#" class="submenu-link">Meet The Teachers</a></li>
              <li><a href="#" class="submenu-link">Current Vacancies</a></li>
            </ul>
          </div>
        </li>
    </ul>
  </div>

  <!-- Sidebar Footer -->
  <div class="mt-auto px-5 py-4">
    <hr class="custom-hr">
    <div class="input-group bg-white rounded-0 p-2">
      <span class="input-group-text bg-transparent border-0 text-muted">Search</span>
      <input type="text" class="form-control border-0 shadow-none">
      <span class="input-group-text bg-transparent border-0">
        <svg width="18" height="18" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
      </span>
    </div>
  </div>

</aside>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
