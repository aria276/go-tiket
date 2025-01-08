document.addEventListener("DOMContentLoaded", () => {
    function calculateHotelPrice() {
      const roomType = document.querySelector("input[name='kamar']:checked");
      const nights = parseInt(document.getElementById("durasi").value);
      const roomCount = parseInt(document.getElementById("jumlah_kamar").value);
  
      if (roomType && !isNaN(nights) && !isNaN(roomCount)) {
        let pricePerNight = 0;
  
        switch (roomType.value) {
          case "standard":
            pricePerNight = 500000;
            break;
          case "deluxe":
            pricePerNight = 1000000;
            break;
          case "suite":
            pricePerNight = 2000000;
            break;
        }
  
        const totalPrice = pricePerNight * nights * roomCount;
        alert(`Total biaya kamar: Rp ${totalPrice.toLocaleString("id-ID")}`);
      }
    }
  
    function calculateTourPrice() {
      const touristSpot = document.querySelector("input[name='wisata']:checked");
      const ticketCount = parseInt(document.getElementById("jumlah_tiket").value);
  
      if (touristSpot && !isNaN(ticketCount)) {
        let pricePerTicket = 0;
  
        switch (touristSpot.value) {
          case "pantai":
            pricePerTicket = 15000;
            break;
          case "gunung":
            pricePerTicket = 50000;
            break;
          case "taman":
            pricePerTicket = 25000;
            break;
        }
  
        const totalPrice = pricePerTicket * ticketCount;
        alert(`Total biaya tiket wisata: Rp ${totalPrice.toLocaleString("id-ID")}`);
      }
    }
  
    document.querySelector("form[action='confirmation.php']").addEventListener("submit", (e) => {
      e.preventDefault();
      calculateHotelPrice();
      e.target.submit();
    });
  
    document.querySelector("form[action='proses_booking.php']").addEventListener("submit", (e) => {
      e.preventDefault();
      calculateTourPrice();
      e.target.submit();
    });
  });
  