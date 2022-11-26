 <!-- ======= F.A.Q Section ======= -->
 <section id="faq" class="faq">

<div class="container" data-aos="fade-up">

  <header class="section-header">
    <h2>F.A.Q</h2>
    <p>Frequently Asked Questions</p>
  </header>

  <div class="row">
    <div class="col-lg-6">
      <!-- F.A.Q List 1-->
      <div class="accordion accordion-flush" id="faqlist1">
          @foreach($faq_first as $f_faq)
          <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-{{$f_faq->id}}">
              {{$f_faq->question}}
            </button>
          </h2>
          <div id="faq-content-{{$f_faq->id}}" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
            <div class="accordion-body">
                {{$f_faq->answer}}
            </div>
          </div>
        </div>
          @endforeach
      </div>
    </div>

    <div class="col-lg-6">

      <!-- F.A.Q List 2-->
      <div class="accordion accordion-flush" id="faqlist2">
          @foreach($faq_second as $s_faq)
          <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2-content-{{$s_faq->id}}">
              {{$s_faq->question}}
            </button>
          </h2>
          <div id="faq2-content-{{$s_faq->id}}" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
            <div class="accordion-body">
              {{$s_faq->answer}}
            </div>
          </div>
        </div>
          @endforeach
      </div>
    </div>

  </div>

</div>

</section><!-- End F.A.Q Section -->