<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="{{route('dashboard')}}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->



  <li class="nav-heading">Pages</li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('profile', [$loggedUser->id])}}">
      <i class="bi bi-person"></i>
      <span>Profile</span>
    </a>
  </li><!-- End Profile Page Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('wallets.index')}}">
      <i class="bi bi-person"></i>
      <span>Wallets</span>
    </a>
  </li><!-- End Profile Page Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('credit.offline')}}">
      <i class="bi bi-person"></i>
      <span>Funding</span>
    </a>
  </li><!-- End Profile Page Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('offline.debit', [Auth::user()->id])}}">
      <i class="bi bi-person"></i>
      <span>Withdrawal</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('faq')}}">
      <i class="bi bi-question-circle"></i>
      <span>F.A.Q</span>
    </a>
  </li><!-- End F.A.Q Page Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('contactus')}}">
      <i class="bi bi-envelope"></i>
      <span>Contact Us</span>
    </a>
  </li><!-- End Contact Page Nav -->






</ul>

</aside>
