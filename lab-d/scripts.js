const API_KEY = "0010748bb1a4b34b300be8f4ceff1cd8";

document.getElementById("weatherBtn").addEventListener("click", () => {
  const city = document.getElementById("cityInput").value;
  if (!city) return alert("Wpisz nazwę miasta!");

  getCurrentWeather(city);
  getForecast(city);
});


function getCurrentWeather(city) {
  const url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${API_KEY}&units=metric&lang=pl`;

  const xhr = new XMLHttpRequest();
  xhr.open("GET", url);

  xhr.onload = function () {
    console.log("Current weather response:", JSON.parse(xhr.responseText));
    const data = JSON.parse(xhr.responseText);
    document.getElementById("currentWeather").innerHTML = `
    <div class="weather-card">
        <h2>Pogoda bieżąca</h2>
        <p><strong>Temperatura:</strong> ${data.main.temp}°C</p>
        <p><strong>Odczuwalna:</strong> ${data.main.feels_like}°C</p>
        <p><strong>Opis:</strong> ${data.weather[0].description}</p>
        <p><strong>Wilgotność:</strong> ${data.main.humidity}%</p>
        <p><strong>Wiatr:</strong> ${data.wind.speed} m/s</p>
    </div>`;
  };

  xhr.send();
}
function getForecast(city) {
  const url = `https://api.openweathermap.org/data/2.5/forecast?q=${city}&appid=${API_KEY}&units=metric&lang=pl`;

  fetch(url)
    .then(res => res.json())
    .then(data => {
      console.log("Forecast response:", data);

      let html = "<h2>Prognoza 5 dni</h2>";

      data.list.forEach(item => {
        html += `
                    <div class="forecast-item">
                        <p><strong>${item.dt_txt}</strong></p>
                        <p>🌡 Temp: ${item.main.temp}°C</p>
                        <p>🌥 ${item.weather[0].description}</p>
                        <p>💨 Wiatr: ${item.wind.speed} m/s</p>
                    </div>
                `;
      });
      document.getElementById("forecast").innerHTML = html;
    });
}
