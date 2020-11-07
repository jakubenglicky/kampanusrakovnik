var supportsPassive = false;
try {
  var opts = Object.defineProperty({}, 'passive', {
    get: function() {
      supportsPassive = true;
    }
  });
  window.addEventListener("testPassive", null, opts);
  window.removeEventListener("testPassive", null, opts);
} catch (e) {}

let clickDropdown = document.querySelectorAll(".click-dropdown");
clickDropdown.forEach(clickDrop => {
    let openElement = clickDrop.querySelector(".open-drop")
    openElement.addEventListener("click", () => {
        if (openElement.className.includes("no-close")) {
            clickDrop.classList.add("is-show");
        } else {
            clickDrop.classList.toggle("is-show");
        }
    }, supportsPassive ? { passive: true } : false);
});
window.addEventListener("click", (event) => {
    clickDropdown.forEach(clickDropd => {
        if (!event.composedPath().includes(clickDropd) && !clickDropd.className.includes("win-not-close")) {
            clickDropd.classList.remove("is-show");
        } else if (event.composedPath().includes(clickDropd) && !event.composedPath().includes(clickDropd.querySelector(".click-dropdown-content")) && !event.composedPath().includes(clickDropd.querySelector(".open-drop")) && !clickDropd.className.includes("win-not-close")) {
            clickDropd.classList.remove("is-show");
        }
    });
}, supportsPassive ? { passive: true } : false);