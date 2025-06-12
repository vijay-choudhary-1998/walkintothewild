  <div class="sidebar-wrapper" data-simplebar="init">
      <div class="simplebar-wrapper" style="margin: 0px;">
          <div class="simplebar-height-auto-observer-wrapper">
              <div class="simplebar-height-auto-observer"></div>
          </div>
          <div class="simplebar-mask">
              <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                  <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;">
                      <div class="simplebar-content mm-active" style="padding: 0px;">
                          <div class="sidebar-header">
                              <div>
                                  <img src="{{ asset('assets/images/WLogoLightgreen.svg') }}" class="logo-icon"
                                      alt="logo icon">
                              </div>
                              <div>
                                  <h4 class="logo-text">SafariMeet</h4>
                              </div>
                              <div class="toggle-icon ms-auto"><i class="bx bx-arrow-to-left"></i>
                              </div>
                          </div>
                          <!--navigation-->
                          <ul class="metismenu mm-show" id="menu">
                              <li>
                                  <a href="{{ route('admin.dashboard') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Dashboard</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.park') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Park</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.wildlife') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">WildLife</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.share.safari') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Share Safari</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.city') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">City</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.state') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">State</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.country') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Country</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.faqs') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Faqs</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.faqs.category') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Faqs Category</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.albums') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Albums</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.contact_us') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Contact Us</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.about_us') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">About Us</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.privacy_policy') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Privacy Policy</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.refund_policy') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Refund Policy</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.terms_and_conditions') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Terms and Conditions</div>
                                  </a>
                              </li>
                              <li>
                                  <a href="{{ route('admin.settings') }}" wire:navigate wire:current="mm-active">
                                      <div class="parent-icon"><i class="bx bx-home-circle"></i>
                                      </div>
                                      <div class="menu-title">Site Settings</div>
                                  </a>
                              </li>
                          </ul>
                          <!--end navigation-->
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
