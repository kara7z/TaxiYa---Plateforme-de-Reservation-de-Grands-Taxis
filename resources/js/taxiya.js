// TaxiYa small JS helpers (kept minimal; Alpine handles most UI)
(function(){
  // theme toggle (light/dark)
  const storageKey = "taxiya_theme";
  const root = document.documentElement;
  const setTheme = (mode) => {
    if(mode === "dark"){ root.classList.add("dark"); }
    else { root.classList.remove("dark"); }
    localStorage.setItem(storageKey, mode);
  };
  window.TaxiYaTheme = {
    init(){
      const saved = localStorage.getItem(storageKey);
      if(saved){ setTheme(saved); return; }
      // default: follow system
      const prefersDark = window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches;
      setTheme(prefersDark ? "dark" : "light");
    },
    toggle(){
      const isDark = root.classList.contains("dark");
      setTheme(isDark ? "light" : "dark");
    }
  };

  document.addEventListener("DOMContentLoaded", () => {
    window.TaxiYaTheme?.init?.();
    // lucide icons
    if(window.lucide?.createIcons){ window.lucide.createIcons(); }
  });
})();
