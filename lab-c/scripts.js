console.debug("LAB C started");

//MAPA
let map = L.map('map').setView([52, 19], 6);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19
}).addTo(map);

let marker = null;

//LOKALIZACJA
document.getElementById("btnLocate").onclick = () => {
  navigator.geolocation.getCurrentPosition(pos => {
    let lat = pos.coords.latitude;
    let lon = pos.coords.longitude;

    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lon]).addTo(map);

    map.setView([lat, lon], 15);

    console.debug("Twoja lokalizacja:", lat, lon);
  });
};

//POBIERANIE MAPY DO CANVAS (leaflet-image)
document.getElementById("btnDownload").onclick = () => {
  leafletImage(map, function(err, canvas) {
    if (err) {
      console.error(err);
      return;
    }
    createPuzzle(canvas);
  });
};

//TWORZENIE PUZZLI
function createPuzzle(canvas) {
  const piecesDiv = document.getElementById("pieces");
  const boardDiv = document.getElementById("board");

  piecesDiv.innerHTML = "";
  boardDiv.innerHTML = "";

  let pieces = [];
  let id = 0;

  // Створюємо пазли
  for (let y = 0; y < 4; y++) {
    for (let x = 0; x < 4; x++) {

      let piece = document.createElement("div");
      piece.classList.add("piece");
      piece.draggable = true;
      piece.dataset.correct = id;

      piece.style.backgroundImage = `url(${canvas.toDataURL()})`;
      piece.style.backgroundPosition = `-${x * 100}px -${y * 100}px`;

      piece.addEventListener("dragstart", dragStart);

      pieces.push(piece);

      let slot = document.createElement("div");
      slot.classList.add("piece");
      slot.dataset.slot = id;
      slot.addEventListener("dragover", dragOver);
      slot.addEventListener("drop", dropPiece);

      boardDiv.appendChild(slot);

      id++;
    }
  }

  //Fisher–Yates shuffle
  for (let i = pieces.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [pieces[i], pieces[j]] = [pieces[j], pieces[i]];
  }

  pieces.forEach(p => piecesDiv.appendChild(p));
}

//DRAG & DROP
let dragged = null;

function dragStart(e) {
  dragged = e.target;
}

function dragOver(e) {
  e.preventDefault();
}

function dropPiece(e) {
  if (!dragged) return;

  e.target.style.backgroundImage = dragged.style.backgroundImage;
  e.target.style.backgroundPosition = dragged.style.backgroundPosition;
  e.target.dataset.piece = dragged.dataset.correct;

  dragged.remove();

  checkWin();
}

//SPRAWDZANIE UKOŃCZENIA
function checkWin() {
  const slots = document.querySelectorAll("#board .piece");

  for (let slot of slots) {
    if (slot.dataset.slot !== slot.dataset.piece) return;
  }

  console.debug("Ułożono poprawnie!");

  Notification.requestPermission().then(() => {
    new Notification("Gratulacje!", {
      body: "Ułożyłeś wszystkie puzzle!"
    });
  });
}
