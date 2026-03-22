  <!-- NAV 2  -->
        <nav class="navbar navbar-light navbar-vertical navbar-expand-xl" style="display: none;">
          <script>
            var navbarStyle = localStorage.getItem("navbarStyle");
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
            }
          </script>

          <div class="d-flex align-items-center">
            <div class="toggle-icon-wrapper">
              <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation">
                <span class="navbar-toggle-icon">
                  <span class="toggle-line"></span>
                </span>
              </button>
            </div>

            <a class="navbar-brand" href="index.html">
              <div class="d-flex align-items-center py-3">
                <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="40" />
                <span class="font-sans-serif text-primary">fleave</span>
              </div>
            </a>

          </div>

          <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <div class="navbar-vertical-content scrollbar">
              <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                
                <!-- DASHBOARD  -->
                <li class="nav-item"><!-- parent pages-->
                  
                
                  <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="dashboard">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1">Dashboard</span></div>
                  </a>
                  <ul class="nav collapse show" id="dashboard">
                    <li class="nav-item"><a class="nav-link active" href="index.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Default</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard/analytics.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Analytics</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard/crm.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">CRM</span></div>
                      </a><!-- more inner pages--></li>
                    
                    <li class="nav-item"><a class="nav-link" href="dashboard/project-management.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Management</span></div>
                      </a><!-- more inner pages--></li>
                    
                    <li class="nav-item"><a class="nav-link" href="dashboard/support-desk.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Support desk</span><span class="badge rounded-pill ms-2 badge-subtle-success">New</span></div>
                      </a><!-- more inner pages--></li>

                  </ul>
                </li>


                <!-- PROFILES  -->
                <li class="nav-item"><!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Profile</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator" href="#user" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="user">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user"></span></span><span class="nav-link-text ps-1">User</span></div>
                  </a>
                  <ul class="nav collapse" id="user">
                    <li class="nav-item"><a class="nav-link" href="pages/user/profile.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Profile</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="pages/user/settings.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Settings</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->

                  <a class="nav-link" href="pages/starter.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-flag"></span></span><span class="nav-link-text ps-1">Starter</span></div>
                  </a><!-- parent pages-->
                  
                </li>


                <!-- APPS  -->
                <li class="nav-item"><!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">App</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages-->
                  
                  <a class="nav-link" href="app/calendar.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar-alt"></span></span><span class="nav-link-text ps-1">Calendar</span></div>
                  </a><!-- parent pages-->
                  
                  <a class="nav-link" href="app/chat.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-comments"></span></span><span class="nav-link-text ps-1">Chat</span></div>
                  </a><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator" href="#email" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="email">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-envelope-open"></span></span><span class="nav-link-text ps-1">Email</span></div>
                  </a>
                  <ul class="nav collapse" id="email">
                    <li class="nav-item"><a class="nav-link" href="app/email/inbox.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Inbox</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/email/email-detail.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Email detail</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/email/compose.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Compose</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator" href="#events" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="events">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-calendar-day"></span></span><span class="nav-link-text ps-1">Events</span></div>
                  </a>
                  <ul class="nav collapse" id="events">
                    <li class="nav-item"><a class="nav-link" href="app/events/create-an-event.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create an event</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/events/event-detail.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Event detail</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/events/event-list.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Event list</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->
                  
                  
                  <a class="nav-link dropdown-indicator" href="#e-learning" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="e-learning">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-graduation-cap"></span></span><span class="nav-link-text ps-1">E learning</span><span class="badge rounded-pill ms-2 badge-subtle-success">New</span></div>
                  </a>
                  <ul class="nav collapse" id="e-learning">
                    <li class="nav-item"><a class="nav-link dropdown-indicator" href="#course" data-bs-toggle="collapse" aria-expanded="false" aria-controls="e-learning">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Course</span></div>
                      </a><!-- more inner pages-->
                      <ul class="nav collapse" id="course">
                        <li class="nav-item"><a class="nav-link" href="app/e-learning/course/course-list.html">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Course list</span></div>
                          </a><!-- more inner pages--></li>
                        <li class="nav-item"><a class="nav-link" href="app/e-learning/course/course-grid.html">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Course grid</span></div>
                          </a><!-- more inner pages--></li>
                        <li class="nav-item"><a class="nav-link" href="app/e-learning/course/course-details.html">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Course details</span></div>
                          </a><!-- more inner pages--></li>
                        <li class="nav-item"><a class="nav-link" href="app/e-learning/course/create-a-course.html">
                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Create a course</span></div>
                          </a><!-- more inner pages--></li>
                      </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="app/e-learning/student-overview.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Student overview</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/e-learning/trainer-profile.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Trainer profile</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->
                  
                  
                  <a class="nav-link dropdown-indicator" href="#support-desk" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="support-desk">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-ticket-alt"></span></span><span class="nav-link-text ps-1">Support desk</span></div>
                  </a>
                  <ul class="nav collapse" id="support-desk">
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/table-view.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Table view</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/card-view.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Card view</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/contacts.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Contacts</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/contact-details.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Contact details</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/tickets-preview.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Tickets preview</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/quick-links.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Quick links</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="app/support-desk/reports.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Reports</span></div>
                      </a><!-- more inner pages--></li>
                  </ul>


                </li>


                <!-- DOCUMENTATION  -->
                <li class="nav-item"><!-- label-->
                  <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                    <div class="col-auto navbar-vertical-label">Documentation</div>
                    <div class="col ps-0">
                      <hr class="mb-0 navbar-vertical-divider" />
                    </div>
                  </div><!-- parent pages--><a class="nav-link" href="documentation/getting-started.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-rocket"></span></span><span class="nav-link-text ps-1">Getting started</span></div>
                  </a><!-- parent pages-->


                  <a class="nav-link dropdown-indicator" href="#pricing" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="pricing">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-tags"></span></span><span class="nav-link-text ps-1">Pricing</span></div>
                  </a>
                  <ul class="nav collapse" id="pricing">
                    <li class="nav-item"><a class="nav-link" href="pages/pricing/pricing-default.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Pricing default</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="pages/pricing/pricing-alt.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Pricing alt</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->
                  
                  <a class="nav-link dropdown-indicator" href="#customization" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="customization">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-wrench"></span></span><span class="nav-link-text ps-1">Customization</span></div>
                  </a>
                  <ul class="nav collapse" id="customization">
                    <li class="nav-item"><a class="nav-link" href="documentation/customization/configuration.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Configuration</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="documentation/customization/styling.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Styling</span><span class="badge rounded-pill ms-2 badge-subtle-success">Updated</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="documentation/customization/dark-mode.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Dark mode</span></div>
                      </a><!-- more inner pages--></li>
                    <li class="nav-item"><a class="nav-link" href="documentation/customization/plugin.html">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Plugin</span></div>
                      </a><!-- more inner pages--></li>
                  </ul><!-- parent pages-->
                  
                  <a class="nav-link" href="documentation/faq.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-question-circle"></span></span><span class="nav-link-text ps-1">Faq</span></div>
                  </a><!-- parent pages-->
                  
                  <a class="nav-link" href="changelog.html" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-code-branch"></span></span><span class="nav-link-text ps-1">Changelog</span></div>
                  </a>
                </li>

              </ul>


              <!-- SEETINGS  -->
              <div class="settings my-3">
                <div class="card shadow-none">
                  <div class="card-body alert mb-0" role="alert">
                    <div class="btn-close-falcon-container"><button class="btn btn-link btn-close-falcon p-0" aria-label="Close" data-bs-dismiss="alert"></button></div>
                    <div class="text-center"><img src="/assets/img/icons/spot-illustrations/navbar-vertical.png" alt="" width="80" />
                      <p class="fs-11 mt-2">Loving what you see? <br />Get your copy of <a href="#!">Fredrick's - LMS</a></p>
                      <div class="d-grid"><a class="btn btn-sm btn-primary" href="#" target="_blank">Purchase</a></div>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </nav>