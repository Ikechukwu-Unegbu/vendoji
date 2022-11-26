 <!-- ======= Footer ======= -->
 <footer id="footer" class="footer">

<div class="footer-newsletter"  id="newsletter">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-12 text-center">
        <h4>Our Newsletter</h4>
        <p>Sign up for our newsletter to recieve our coin market insightful reports.</p>
      </div>
      <div class="col-lg-6">
        <div>
          @if(session()->has('newslettersuccess'))
            <div class="alert alert-success" role="alert">
                <strong>{{ session()->get('newslettersuccess') }}</strong>
            </div>
        @endif
        @if(session()->has('newslettererror'))
            <div class="alert alert-danger" role="alert">
                <strong>{{ session()->get('newslettererror') ? session()->get('newslettererror') : session()->get('errors')[0] }}</strong>
            </div>
        @endif
        </div>
        <form action="{{route('newsletter')}}" method="POST">
          @csrf
          <input type="email" name="email" class="@error('email') is-invalid @enderror">
          <input type="submit" value="Subscribe">
        </form>
        <strong><span class="text-center">@error('email') <span class="text-danger">{{ $message }}</span> @enderror</span></strong>
      </div>
    </div>
  </div>
</div>

<div class="footer-top">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-5 col-md-12 footer-info">
        <a href="index.html" class="logo d-flex align-items-center">
          <img src="assets/img/logo.png" alt="">
          <span>Vendoji</span>
        </a>
        <p>
        Vendoji technology is a leading provider of decentralized finance services like secured stable coin savings. We also provide crypto literacy and consultancy services.
        </p>
        <div class="social-links mt-3">
          <a href="https://twitter.com/Vendoji1" class="twitter"><i class="bi bi-twitter"></i></a>
          <a href="https://www.facebook.com/groups/1547301459121307/?ref=share" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="https://t.me/+74ubZVlEnjM5YmM0" class="instagram"><i class="bi bi-telegram"></i></a>
          <a href="https://www.linkedin.com/groups/12515903" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><i class="bi bi-chevron-right"></i> <a href="/">Home</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="{{route('about.us')}}">About us</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-6 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Secured Savings</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Blockchain Consultancy</a></li>
          <!-- <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li> -->
        </ul>
      </div>

      <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
        <h4>Contact Us</h4>
        <p>
          A108 Adam Street <br>
          New York, NY 535022<br>
          United States <br><br>
          <strong>Phone:</strong> +1 5589 55488 55<br>
          <strong>Email:</strong> info@example.com<br>
        </p>

      </div>

    </div>
  </div>
</div>

<div class="container">
  <div class="copyright">
    &copy; Copyright <strong><span>FlexStart</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexstart-bootstrap-startup-template/ -->
    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
  </div>
</div>
</footer><!-- End Footer -->


<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('pages\vendor\purecounter\purecounter_vanilla.js')}}"></script>
  <script src="{{asset('pages\vendor\aos\aos.js')}}"></script>
  <script src="{{asset('pages\vendor\bootstrap\js\bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('pages\vendor\glightbox\js\glightbox.min.js')}}"></script>
  <script src="{{asset('pages\vendor\isotope-layout\isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('pages\vendor\swiper\swiper-bundle.min.js')}}"></script>
  <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->

  <!-- Template Main JS File -->
  <script src="{{asset('pages\js\main.js')}}"></script>
