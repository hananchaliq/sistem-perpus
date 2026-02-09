// sistem ganti tema gelap untuk alert
function swalTheme(options) {
   const isDark = document.documentElement.classList.contains("dark");

   return Swal.fire({
      background: isDark ? "#0f172a" : "#ffffff",
      color: isDark ? "#f8fafc" : "#020617",
      confirmButtonColor: isDark ? "#38bdf8" : "#2563eb",
      cancelButtonColor: isDark ? "#ef4444" : "#d33",
      ...options,
   });
}

