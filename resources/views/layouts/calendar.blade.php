<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' />
    <link href='http://fonts.googleapis.com/css?family=Hind:400,300,500,600%7cMontserrat:400,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet">
    <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div id='calendar'></div>
    @php
      $databooking = base64_decode($datedata);
    @endphp
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Ambil dan parse data booking dari Laravel (format base64 encoded JSON)
        try {
      var decoded = atob(@json($datedata));
      console.log("Decoded base64:", decoded);

      var bookingData = JSON.parse(decoded).map(function (d) {
        return d.substring(0, 10); // Ambil hanya YYYY-MM-DD
      });

      console.log("Parsed bookingData:", bookingData);
    } catch (e) {
      console.error("Gagal parsing bookingData:", e);
    }


    console.log("Booking data:", bookingData); // ✅ Debug, pastikan datanya muncul

    var eventsData = bookingData.map(function (dateString) {
      return {
        title: '',
        start: dateString,
        allDay: true
      };
    });

    $('#calendar').fullCalendar({
      header: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      defaultDate: moment().format("YYYY-MM-DD"),
      editable: false,
      events: eventsData,
      height: 'auto',

      eventRender: function (event, element) {
        element.find('.fc-title').remove();
        element.css({
          'background-color': 'transparent',
          'border': 'none'
        });
      },
      

      // Inilah yang akan blok cell-nya langsung
      eventAfterAllRender: function (view) {
        $('.fc-day').each(function () {
          var cellDate = $(this).data('date'); // contoh: '2025-07-08'
          if (bookingData.includes(cellDate)) {
            $(this).css('background-color', '#ff0000');
            $(this).css('color', 'white'); // opsional: biar angka tanggal tetap kelihatan
          }
        });
      }
    });
  });
  console.log("Booking data:", bookingData);

</script>


    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: 'Hind', sans-serif;
      }

      #calendar {
        width: 100%;
        height: auto;
        font-family: 'Hind', sans-serif;
      }

      @media (max-width: 768px) {
        #calendar {
          font-size: 10px;
        }
      }
      .fc {
  background-color: white !important;
}
/* Pastikan font kalender tetap nyaman dibaca */
.fc-day-number {
  z-index: 10;
  position: relative;
}

/* Smooth coloring */
.fc-day[data-date] {
  transition: background-color 0.3s ease;
}


      .fc-day-grid .fc-day,
      .fc-day-grid .fc-day-top {
        width: 12px !important;
        height: 12px !important;
        line-height: 12px !important;
        text-align: center;
        position: relative;
        overflow: hidden;
        font-family: 'Hind', sans-serif;
      }

      /* Menyesuaikan ukuran border */
      .fc-day-grid .fc-day[data-date]:before,
      .fc-day-grid .fc-day[data-date]:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border: 1px solid transparent;
        border-radius: 5px;
      }

      .fc-day-number {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: black !important;
        font-size: 13px; /* Ubah ukuran teks */
        font-family: 'Hind', sans-serif;
      }

      .fc-content-skeleton {
        padding-top: 10px; /* Sesuaikan nilai ini sesuai kebutuhan */
        font-family: 'Hind', sans-serif;
      }

      .fc-day-header {
        color: white !important;
        font-size: 10px;
        font-family: 'Montserrat', sans-serif;
      }

      .fc-day-grid .fc-day {
        border-color: transparent !important;
        position: relative;
        padding: 0;
        font-family: 'Hind', sans-serif;
      }

      .fc-widget-header {
        border-color: transparent !important;
        font-family: 'Montserrat', sans-serif;
      }

      .fc-view,
      .fc-view>table {
        border-color: transparent !important;
        font-family: 'Hind', sans-serif;
      }

      .fc-prev-button,
      .fc-next-button {
        background: none;
        border: none;
        font-size: 0;
        color: black !important;
        font-family: 'Montserrat', sans-serif;
      }

      .fc-unthemed .fc-widget-content {
        border-color: black !important;
        font-family: 'Hind', sans-serif;
      }

      .fc-widget-header {
        border-color: black !important;
        font-size: 12px;
        color: black !important; /* Warna teks bulan */
        font-family: 'Montserrat', sans-serif;
      }

      .fc-toolbar h2 {
        color: black !important;
        font-family: 'Montserrat', sans-serif;
      }
    </style>
  </body>
</html>
