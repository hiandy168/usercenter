function a() {
  return !1
}! function(n, e) {
  var t = n.documentElement,
    d = "orientationchange" in window ? "orientationchange" : "resize",
    i = function() {
      var n = t.clientWidth;
      n && (n < 750 || 750 == n ? t.style.fontSize = 1 * (n / 15) + "px" : t.style.fontSize = "50px")
    };
  n.addEventListener && (e.addEventListener(d, i, !1), n.addEventListener("DOMContentLoaded", i, !1))
}(document, window), document.addEventListener("touchstart", a, !1)



// loading
window.onload = function() {
  document.getElementById("loaddiv").style.display = "none"
};