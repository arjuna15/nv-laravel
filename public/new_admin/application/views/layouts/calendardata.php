<!DOCTYPE html>
<html lang="en">

  <head>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' />
    <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>


    <div id='calendar'></div>
        <?php
            $databooking = base64_decode($datedata);
            ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var parsephp = '<?php echo $databooking ?>';
                var bookingData = JSON.parse(parsephp);
                var eventsData = bookingData.map(function(dateString) {
                    return {
                        title: 'Pemesanan',
                        start: dateString
                    };
                });

                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev',
                        center: 'title',
                        right: 'next'
                    },
                    scrollTime: '00:00', // Set the initial scroll time to midnight
                    height: 'auto', // Set the height to auto to disable vertical scrolling
                    // Add your events or event sources here
                    defaultDate: new Date(),
                    editable: false,
                    events: eventsData,
                    dayRender: function(date, cell) {
                        if (date.isBefore(moment(), 'day')) {
                            cell.css('background-color', 'transparent');
                        } else if (date > moment()) {
                            cell.css('background-color', '#40d726');
                        } else if (date.isSame(moment(), 'day')) {
                            cell.css('background-color', '#40d726');
                        }

                        var dateString = date.format('YYYY-MM-DD');
                        if (bookingData.indexOf(dateString) !== -1) {
                            cell.css('background-color', '#ff0000');
                        }
                        
                    },
                    eventRender: function(event, element) {
                        element.find('.fc-title').remove();
                        element.css('border', 'none');
                    }
                });
            });
        </script>
        <style>
    body {
      margin: 0;
      padding: 0;
    }

    #calendar {
      width: 100%;
      height: auto;
    }

    @media (max-width: 768px) {
      #calendar {
        font-size: 10px;
      }
    }

    .fc-day-grid .fc-day,
.fc-day-grid .fc-day-top {
  width: 12px !important;
  height: 12px !important;
  line-height: 12px !important;
  text-align: center;
  position: relative;
  overflow: hidden;
  border-radius: 5px;
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
  color: white !important;
  font-size: 15px; /* Ubah ukuran teks */
}
.fc-content-skeleton {
  padding-top: 10px; /* Sesuaikan nilai ini sesuai kebutuhan */
}
    .fc-day-header {
      color: white !important;
      font-size: 14px;
    }

    .fc-day-grid .fc-day {
      border-color: transparent !important;
      position: relative;
      padding: 0;
    }

    .fc-widget-header {
      border-color: transparent !important;
    }

    .fc-view,
    .fc-view>table {
      border-color: transparent !important;
    }

    .fc-prev-button,
    .fc-next-button {
      background: none;
      border: none;
      font-size: 0;
      color: white !important;
    }

    .fc-unthemed .fc-widget-content {
      border-color: transparent !important;
    }
    .fc-widget-header {
      border-color: transparent !important;
      color: white !important; /* Warna teks bulan */
    }
    .fc-toolbar h2 {
      color: white !important;
    }
  </style>

  
  </body>
</html>