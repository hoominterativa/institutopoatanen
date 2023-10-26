
{{-- BEGIN Page content --}}
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.2.0/main.js"></script>

<!-- interaction plugin must be included after core -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.2.0/main.js"></script>

<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css" rel="stylesheet"/>


<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"
/>



<section id="ligtbox-sche02-page" class="lipa">
    <header class="lipa__banner" style="background-image:url({{asset('storage/uploads/tmp/bg-banner-inner.png')}}); background-color:;">
        <button  class="lipa__banner__close">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24" viewBox="0 0 14 24" fill="none">
                <path d="M0.93934 10.9393C0.353553 11.5251 0.353553 12.4749 0.93934 13.0607L10.4853 22.6066C11.0711 23.1924 12.0208 23.1924 12.6066 22.6066C13.1924 22.0208 13.1924 21.0711 12.6066 20.4853L4.12132 12L12.6066 3.51472C13.1924 2.92893 13.1924 1.97919 12.6066 1.3934C12.0208 0.807611 11.0711 0.807611 10.4853 1.3934L0.93934 10.9393ZM3 10.5H2L2 13.5H3V10.5Z" fill="#404040"/>
            </svg>
            Agenda
        </button>
        <div class="lipa__banner__mask"></div>
        <div class="container container--lipa px-0 d-flex justify-content-between">
            <div class="lipa__banner__left">
                <h4 class="lipa__banner__left__title">Titulo do banner</h4>
                <h5 class="lipa__banner__left__subtitle">SUBTITULO</h5>
            </div>
            <div class="lipa__banner__right">
                <div class="lipa__banner__right__logo">
                        <img src="{{ asset('storage/uploads/tmp/bg-gray.png') }}" alt="">
                </div>
            </div>    
        </div>
        @include('Client.pages.Schedules.SCHE02.show', [
            'schedules' => $schedules
        ])
    </header>
    <div id="calendar" class="lipa__calendar">
        <script>
            
        
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                locale:'pt-br',
                // initialView: 'dayGridMonth',
                selectable:true,
                // initialDate: '2023-09-07',
                plugins: [ 'dayGrid', 'interaction' ],
                // headerToolbar: {
                //     left: 'prev,next',
                //     center: 'dayGridMonth',
                //     right: 'timeGridWeek,timeGridDay'
                // },
                // defaultView: 'dayGridMonth',
                // contentHeight: 'auto',

                events: [
                    @foreach ($schedules as $schedule)
                    {
                        title: '{{$schedule->event_locale}}',
                        start: '{{$schedule->event_date}}',
                    },
                    @endforeach
                ],
                
                dateClick: function(info) {
                    document.getElementById('ligtbox-SCHE02-show').style.display = 'flex';
                    document.getElementById('ligtbox-sche02-page').style.overflow = 'hidden';
                    

                    // let eventos = info;
                    // console.log(eventos);
                },
            });
          calendar.render();
       
        </script>
    </div>
</section>    
{{-- Finish Content page Here --}}





