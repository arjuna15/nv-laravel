<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Kalender Pemesanan</title>
      <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' />
      <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
      <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    </head>
    <body>
    
      <div id='calendar'></div>
    
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          var bookingData = [
            '2023-12-01',
            '2023-12-05',
            '2023-12-10',
            '2024-01-01'
          ];
    
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
            defaultDate: new Date(),
            editable: false,
            events: eventsData,
            dayRender: function(date, cell) {
              if (date > moment()) {
                cell.css('background-color', '#40d726');
              }
    
              var dateString = date.format('YYYY-MM-DD');
              if (bookingData.indexOf(dateString) !== -1) {
                cell.css('background-color', '#ff0000');
              }
              if (date.isSame(moment(), 'day')) {
                cell.css('background-color', '#40d726');
              }
            },
            eventRender: function(event, element) {
              element.find('.fc-title').remove();
              element.css('border', 'none');
            }
          });
        });
      </script>
    
    </body>
    </html>