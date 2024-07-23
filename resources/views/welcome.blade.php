<!DOCTYPE html>
<html lang="en">
  <head>
 <style>
  .features-list-box{
    height: 245px;
  }
  @media only screen and (max-width: 600px) {
    .features-list-box {
    height: 600px;
  }
}
</style>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
      crossorigin="anonymous"
    />
    <!-- Title & Favicon -->
    <title>Consent SMS</title>
    <!-- CSS Link -->
    <link rel="stylesheet" href="{{asset('webtheme/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('css/responsive.css')}}" />
  </head>
  <body>
    <!-- ====================================== Start Header Section Here ====================================== -->
    <header id="header-section">
      <!-- Navbar For Mobile -->
      <div id="fullnav" class="fullnav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">
          <img src="{{asset('webtheme/img/menu-1.svg')}}" alt="menu" />
        </a>
        <div class="fullnav-content">
          <ul class="navbar-nav ms-auto text-center text-white">
            <li class="nav-item">
              <a
                class="nav-link active"
                aria-current="page"
                href="#header-section"
                >Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about-section">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#features-section">Features</a>
            </li>
            <li class="nav-item">
              <a
                href="javascript:void(0)"
                class="nav-link button nav-btn px-5 text-white"
                >Login</a
              >
            </li>
            <li class="nav-item">
              <a
                onclick="document.getElementById('id01').style.display='block'"
                href="javascript:void(0)"
                class="nav-link button nav-btn px-5 text-white"
                >Contact Us</a
              >
            </li>
          </ul>
        </div>
      </div>
      <!-- Navbar -->
      <nav class="navbar fixed-top navbar-expand-lg py-4 py-xxl-5">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}"
            ><img src="{{asset('webtheme/img/logo.png')}}" alt="logo" class="img-fluid"
          /></a>
          <button
            style="background-color: transparent"
            onclick="openNav()"
            class="border-0 d-lg-none"
          >
            <img src="{{asset('webtheme/img/menu-2.svg')}}" alt="menu" />
          </button>
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  aria-current="page"
                  href="#header-section"
                  >Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#about-section">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#features-section">Features</a>
              </li>
              <li class="nav-item">
                <a
                  onclick="document.getElementById('id01').style.display='block'"
                  href="javascript:void(0)"
                  class="nav-link button nav-btn px-5 text-white"
                  >Contact Us</a
                >
              </li>
              <li class="nav-item">
                <a
                  href="{{ route('login') }}"
                  class="nav-link button nav-btn px-5 text-white"
                  >Login</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- Header Content -->
      <div class="container">
        <div class="header-content">
          <div class="row justify-content-start">
            <div class="col-md-10 col-lg-6 col-xxl-6">
              <h1 class="poligon-bold mb-5">
                Getting Consent to Contact your customers has never been more
                secure and easy to do. Build trust with your customers with
                ConsentSMS.com
              </h1>
              <div class="get-started-box mt-5">
                <form action="javascript:void(0)">
                  <div class="row g-4">
                    <div class="col-6">
                      <input
                        required
                        type="text"
                        class="w-100"
                        placeholder="First Name"
			name="fName"
                      />
                    </div>
                    <div class="col-6">
                      <input
                        required
                        type="text"
                        class="w-100"
                        placeholder="Last Name"
			name="lName"
                      />
                    </div>
	
                    <div class="col-sm-6">
                      <input
                        required
                        type="email"
                        class="w-100"
                        placeholder="Email"
			name="email"
                      />
                    </div>
                    <div class="col-sm-6">
                      <input
                        required
                        type="text"
                        class="w-100"
                        placeholder="Phone Number"
			name="phone"
                      />
                    </div>
                    <div class="col-12">
                      <textarea
                        required
                        style="height: 9rem"
                        name="Message"
                        class="w-100 border-0 pb-2"
                        placeholder="Message"
                      ></textarea>
                    </div>
                    <div class="col-12 text-center text-sm-start">
                      <button class="button border-0">Contact me!</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- ====================================== End Header Section Here ====================================== -->

    <!-- ====================================== Start About Section Here ====================================== -->
    <section id="about-section">
      <div class="container">
        <!-- What is Consent SMS -->
        <div class="row">
          <div class="col-lg-6 align-self-center">
            <h2 class="heading">What is ConsentSMS?</h2>
            <div class="col-lg-6 mt-5 d-lg-none align-self-center">
              <img
                src="{{asset('webtheme/img/what-is-consent-sms-img.png')}}"
                alt="image"
                class="img-fluid animation"
              />
            </div>
            <p class="para-size mt-5">
              ConsentSMS is a tool that allows businesses and representatives to
              send text messages to clients. The main focus of
              ConsentSMS is to provide SMS compliance to the businesses.
              According to the Telephone Consumer Protection Act (TCPA).
              ConsentSMS will take written consent from customers
              that proves the companies are now authorized to contact their
              customers.
            </p>
          </div>
          <div class="col-lg-6 d-none d-lg-block align-self-center">
            <img
              src="{{asset('webtheme/img/what-is-consent-sms-img.png')}}"
              alt="image"
              class="img-fluid animation"
            />
          </div>
        </div>
        <!-- How Does Consent SMS Work -->
        <div class="row mt-5 pt-5">
          <div class="col-lg-6 d-none d-lg-block align-self-center">
            <img
              src="{{asset('webtheme/img/how-does-consent-sms-work.png')}}"
              alt="image"
              class="img-fluid animation animation-delay-1"
            />
          </div>
          <div class="col-lg-6 align-self-center">
            <h2 class="heading">How Does it ConsentSMS Work?</h2>
            <div class="col-lg-6 mt-5 d-lg-none align-self-center">
              <img
                src="{{asset('webtheme/img/how-does-consent-sms-work.png')}}"
                alt="image"
                class="img-fluid animation animation-delay-1"
              />
            </div>
            <p class="para-size mt-5">
              Once the customer's contact information is filled into the Consentform,
              the ConsentSms will send a link to the customer's mobile.
              Clicking the link will validate and verify that the information
              provided such as name, email and contact number is correct. If any
              information is to change the customer can update it. Once
              everything looks correct they can click on the submit button.
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- ====================================== End About Section Here ====================================== -->

    <!-- ====================================== Start Features Section Here ====================================== -->
    <section id="features-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-10 col-lg-8 text-center">
            <h2 style="color: #006fff" class="heading">Our Features</h2>
          </div>
        </div>
        <!-- Features List -->
        <div class="row g-0 mt-5 pt-5">
          <div class="col-12">
            <div class="features-list-box">
              <div class="row gy-0">
                <div class="col-md-6">
                  <div class="media d-flex">
                    <i class="fa fa-circle me-4 align-self-center"></i>
                    <div class="media-body para-size">Contact Consent CRM</div>
                  </div>
                  <div class="media d-flex">
                    <i class="fa fa-circle me-4 align-self-center"></i>
                    <div class="media-body para-size">
                      Real time completion verification
                    </div>
                  </div>
                  <div class="media d-flex">
                    <i class="fa fa-circle me-4 align-self-center"></i>
                    <div class="media-body para-size">
                      Easy access user interface
                    </div>
                  </div>
                  <div class="media d-flex">
                    <i class="fa fa-circle me-4 align-self-center"></i>
                    <div class="media-body para-size">
                      Customized messaging to customer
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="media d-flex">
                    <i class="fa fa-circle me-4 align-self-center"></i>
                    <div class="media-body para-size">
                      One time 6 digit password verification
                    </div>
                  </div>
                  <div class="media d-flex">
                    <i class="fa fa-circle me-4 align-self-center"></i>
                    <div class="media-body para-size">
                      Certificate of authenticity come.
                    </div>
                  </div>
                  <div class="media d-flex">
                    <i class="fa fa-circle me-4 align-self-center"></i>
                    <div class="media-body para-size">
                      Time stamp and ip verification of customers consent
                    </div>
                  </div>
                  <div class="media d-flex">
                    <i class="fa fa-circle me-4 align-self-center"></i>
                    <div class="media-body para-size">
                      Many more features to come.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Features Card -->
        <div class="features-card">
          <div class="my-masonry-grid">
            <!-- Item 1 -->
            <div class="my-masonry-grid-item">
              <div class="features-card-box features-card-box-1 mt-5">
                <div class="media d-flex">
                  <img
                    src="{{asset('webtheme/img/features-icon-1.png')}}"
                    alt="image"
                    class="me-4 align-self-center features-icon"
                  />
                  <div class="media-body align-self-center">
                    <h3 class="features-heading">One Time Password (OTP).</h3>
                  </div>
                </div>
                <p class="para-size mt-5">
                  After the customer confirms that the data entered is correct they click on the submit button, an SMS containing a 6 digit one-time
                  password is sent to the customers mobile phone. They will
                  enter the OTP passcode into the webpage link, that will complete
                  and verify their consent to be contacted by the company.
                </p>
              </div>
            </div>
            <!-- Item 2 -->
            <div class="my-masonry-grid-item">
              <div class="features-card-box features-card-box-2 mt-5">
                <div class="media d-flex">
                  <img
                    src="webtheme/img/features-icon-2.png"
                    alt="image"
                    class="me-4 align-self-center features-icon"
                  />
                  <div class="media-body align-self-center">
                    <h3 class="features-heading">Email Certification</h3>
                  </div>
                </div>
                <p class="para-size mt-5">
                  Next, a certificate of authenticity is generated and sent to the customer's Email.
                  Certificate confirms their consent to the contact disclosure. 
                  This email validates customer's name, email,
                  password, phone number and timestamps. Also it records the
                  customers IP address for validation purposes.
                </p>
              </div>
            </div>
            <!-- Item 3 -->
            <div class="my-masonry-grid-item">
              <div class="features-card-box features-card-box-3 mt-5">
                <div class="media d-flex">
                  <img
                    src="webtheme/img/features-icon-3.png"
                    alt="image"
                    class="me-4 align-self-center features-icon"
                  />
                  <div class="media-body align-self-center">
                    <h3 class="features-heading">An Opt-Out SMS</h3>
                  </div>
                </div>
                <p class="para-size mt-5">
                  Opt-out SMS says thanks to the customer for signing up and for
                  providing written consent. This SMS also includes an Opt-out
                  option followed by a link with instructions. If a customer
                  clicks on the opt-out link it will forward the customer's
                  request to the ConsentSMS and customer's data will be removed
                  from our servers.
                </p>
              </div>
            </div>
            <!-- Item 4 -->
            <div class="my-masonry-grid-item">
              <div class="features-card-box features-card-box-4 mt-5">
                <div class="media d-flex">
                  <img
                    src="webtheme/img/features-icon-4.png"
                    alt="image"
                    class="me-4 align-self-center features-icon"
                  />
                  <div class="media-body align-self-center">
                    <h3 class="features-heading">Easy form submission.</h3>
                  </div>
                </div>
                <p class="para-size mt-5">
                  As your contact is approving consent to be contacted, they
                  will receive a text message via consentsms, just need to click
                  on the URL and all the contacts details will be automatically
                  filled. Your contact simply needs to verify the information is
                  accurate and click the submit button. Lastly, verify the otp
                  and agree to the consent form, the customer has now given
                  their written verified consent to be contacted for
                  future products and services.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ====================================== End Features Section Here ====================================== -->

    <!-- ====================================== Start Footer Section Here ====================================== -->
    <footer>
      <div class="container pt-5">
        <div class="footer-widget pt-5">
          <div class="row text-center text-sm-start">
            <div class="col-sm-6 col-lg-4">
              <a href="index.html"
                ><img
                  src="webtheme/img/footer-logo.png"
                  alt="footer-logo"
                  class="w-75 footer-logo"
              /></a>
              <p class="para-size text-white py-5">
                Getting Consent to Contact your customers has never been more
                secure and easy to do. Build trust with your customers with
                ConsentSMS.com
              </p>
            </div>
            <div class="d-none d-lg-block col-lg-4"></div>
            <div class="col-sm-3 col-lg-2 d-none d-sm-block"></div>
            
          </div>
        </div>
        <div class="footer-copyright text-white text-start py-5">
          <div class="row">
            <div
              class="col-sm-6 col-md-7 text-center text-sm-start align-self-center"
            >
              <p>Copyright & Design by @consentsms</p>
            </div>
            <div
              class="col-sm-6 col-md-5 text-center text-sm-end align-self-center"
            >
              <a
                href="{{url('privacypolicy')}}"
                class="me-5 text-white footer-border-end-default"
                >Terms of use
              </a>
              <a href="{{url('privacypolicy')}}" class="text-white" target="_blank">Privacy Policy</a>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- ====================================== End Footer Section Here ====================================== -->

    <!-- Pop Up Contact Form -->
    <div id="id01" class="modal">
      <form class="modal-content animate" action="{{ url('contact') }}" method="post">
	@csrf
        <div class="mt-0 pt-0 imgcontainer">
          <span
            onclick="document.getElementById('id01').style.display='none'"
            class="close"
            title="Close Modal"
            >&times;</span
          >
        </div>
        <div class="container-form">
          <h3>Contact Us</h3>
          <div class="row">
            <div class="col-sm-6 px-2 px-sm-4">
              <label for="fName">First Name</label> <br />
              <input required class="w-100" type="text" name="fName" />
            </div>
            <div class="col-sm-6 px-2 px-sm-4">
              <label for="lName">Last Name</label> <br />
              <input required class="w-100" type="text" name="lName" />
            </div>
            <div class="col-sm-6 px-2 px-sm-4">
              <label for="email">Email</label> <br />
              <input required class="w-100" type="email" name="email" />
            </div>
            <div class="col-sm-6 px-2 px-sm-4">
              <label for="phone">Phone</label> <br />
              <input required class="w-100" type="text" name="phone" />
            </div>
            <div class="col-12 px-2 px-sm-4">
              <label for="message">Message</label> <br />
              <input required class="w-100" type="text" name="message" />
            </div>
            <div class="col-12 text-center pb-4">
              <button>Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!-- Back To Top -->
    <button class="animation animation-delay-2" id="myBtn" title="Go to top">
      <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </button>

    <!-- JavaScript Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
      crossorigin="anonymous"
    ></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Masonry Plugin -->
    <script src="{{asset('js/jquery.masonryGrid.js')}}"></script>
    <script>
      jQuery(document).ready(function ($) {
        $(".my-masonry-grid").masonryGrid({
          columns: 2,
          breakpoint: 767,
        });
      });
    </script>
    <!-- Main JS -->
    <script src="js/main.js"></script>
  </body>
</html>

