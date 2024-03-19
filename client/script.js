const table = document.getElementById("myTable");
const tbody = table.querySelector("tbody");
const rows = Array.from(tbody.getElementsByTagName("tr"));

// Function to compare rows based on the sorting key
function compareRows(key) {
  return function (a, b) {
    const cellA = a.querySelector(`[data-sort="${key}"]`).textContent;
    const cellB = b.querySelector(`[data-sort="${key}"]`).textContent;
    return cellA.localeCompare(cellB);
  };
}

// Function to update the table with sorted rows
function updateTable(key) {
  rows.sort(compareRows(key));
  rows.forEach((row) => tbody.appendChild(row));
}

// Add click event listeners to the header columns for sorting
table.querySelector('[data-sort="name"]').addEventListener("click", () => updateTable("name"));
table.querySelector('[data-sort="request"]').addEventListener("click", () => updateTable("request"));
table.querySelector('[data-sort="date"]').addEventListener("click", () => updateTable("date"));




