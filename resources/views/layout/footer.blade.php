  <!-- footer_start  -->
  <footer class="footer">
      <div class="footer_top">
          <div class="container">
              <div class="row">
                  <div class="col-xl-4 col-md-6 col-lg-4 ">
                      <div class="footer_widget">
                          <div class="footer_logo">
                              <a href="#">
                                  <img src="{{ asset('img/footer_logo.png') }}" alt="">
                              </a>
                          </div>
                          <p class="address_text">
                              {{ __('messages.footerA') }}

                          </p>
                          <div class="socail_links">

                              <a style="color:black;" href="{{ url('lang/en') }}">English &nbsp | </a>
                              <a style="color:black;"href="{{ url('lang/ar') }}"> العربية</a>


                          </div>

                      </div>
                  </div>
                  <div class="col-xl-4 col-md-6 col-lg-4">
                      <div class="footer_widget">
                          <h3 class="footer_title">
                              {{ __('messages.Services') }}
                          </h3>
                          <ul class="links">
                              <li><a href="{{ route('index') }}">{{ __('messages.homeA') }}</a></li>
                              <li><a href="{{ route('about') }}">{{ __('messages.AboutA') }}</a></li>
                              <li><a href="{{ route('organization.all') }}">{{ __('messages.OurorganizationA') }}</a>
                              </li>
                              <li><a href="{{ route('contact') }}">{{ __('messages.ContactA') }}</a></li>
                              <li><a href="{{ route('need') }}">{{ __('messages.MakeDonatitionA') }}</a></li>
                          </ul>
                      </div>
                  </div>
                  <div class="col-xl-4 col-md-6 col-lg-4">
                      <div class="footer_widget">
                          <h3 class="footer_title">
                              {{ __('messages.ContactA') }}
                          </h3>
                          <div class="contacts">
                              <p>+962 (79) 661-5656 <br>
                                  contact@charifit.com <br>

                              </p>
                          </div>
                      </div>
                  </div>

              </div>
          </div>
      </div>
      <div class="copy-right_text">
          <div class="container">
              <div class="row">
                  <div class="bordered_1px "></div>
                  <div class="col-xl-12">
                      <p class="copy_right text-center">

                      </p>
                  </div>
              </div>
          </div>
      </div>
  </footer>
  <!-- footer_end  -->
