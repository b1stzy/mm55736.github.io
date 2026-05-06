// Słownik stylów
const styles: Record<string, string> = {
    retro: "/style-1.css",
    future: "/style-2.css",
    simple: "/style-3.css"
};

// Aktualny styl
let currentStyle = "";

// Funkcja podłączająca styl
function applyStyle(name: string) {
    const old = document.getElementById("dynamic-style");
    if (old) old.remove();

    const link = document.createElement("link");
    link.rel = "stylesheet";
    link.id = "dynamic-style";
    link.href = styles[name];

    document.head.appendChild(link);
    currentStyle = name;
}

// Generowanie przycisków
function generateButtons() {
    const container = document.getElementById("style-switcher")!;
    container.innerHTML = "";

    for (const name in styles) {
        const btn = document.createElement("button");
        btn.textContent = name;
        btn.style.marginRight = "10px";
        btn.onclick = () => applyStyle(name);
        container.appendChild(btn);
    }
}

// Start
generateButtons();
applyStyle("retro");
