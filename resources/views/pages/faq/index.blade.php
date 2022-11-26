@extends('layouts.public')

@section('head')

@endsection

@section('content')
  @include('pages.partials._hero')
  <main class="" id="main">
     <div class="container">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            @foreach($faqcates as $cate)
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{$cate->id}}" aria-expanded="false" aria-controls="flush-collapseOne">
                    {{$cate->name}}
                </button>
                </h2>
                <div id="flush-collapseOne-{{$cate->id}}" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    @foreach($cate->faq as $faq)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center"><b>{{$faq->question}}</b></h5>
                                <div class="">{!!$faq->answer!!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
          
        </div>
     </div>

      
      @include('pages.home.include._contact')
      @include('pages.partials._footer')
  </main>
  <script>
    function contactus(){
      let phone = document.getElementById('phone');
      let email = document.getElementById('email');
      let subject = document.getElementById('subject')
      let message = document.getElementById('message')

    }
  </script>
@endsection 