jQuery(document).ready(function ($) {
  const ctx = document.getElementById("kadpChart");

  if (!ctx) return;

  new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
      datasets: [
        {
          label: "Duplicates",
          data: [5, 10, 7, 12, 8, 15, 9],
          borderWidth: 2,
        },
      ],
    },
    options: {
      responsive: true,
    },
  });
});
