// Sample data for requests (you can replace this with your actual data)
const requests = [
    { id: 1, name: 'Request 1', status: 'Pending' },
    { id: 2, name: 'Request 2', status: 'Approved' },
    { id: 3, name: 'Request 3', status: 'Declined' },
    // Add more requests here
];

// Function to update the dashboard statistics and request table
function updateDashboard() {
    const totalRequests = requests.length;
    const approvedRequests = requests.filter(request => request.status === 'Approved').length;
    const declinedRequests = requests.filter(request => request.status === 'Declined').length;

    document.getElementById('totalRequests').textContent = totalRequests;
    document.getElementById('approvedRequests').textContent = approvedRequests;
    document.getElementById('declinedRequests').textContent = declinedRequests;

    const requestTable = document.getElementById('requestTable');
    requestTable.innerHTML = '';

    requests.forEach(request => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${request.id}</td>
            <td>${request.name}</td>
            <td>
                <button class="approve" onclick="approveRequest(${request.id})">Approve</button>
                <button class="decline" onclick="declineRequest(${request.id})">Decline</button>
                <button class="view" onclick="viewForm(${request.id})">View Form</button>
            </td>
        `;
        requestTable.appendChild(row);
    });
}

// Function to simulate approving a request (you can replace this with actual logic)
function approveRequest(requestId) {
    const request = requests.find(request => request.id === requestId);
    if (request) {
        request.status = 'Approved';
        updateDashboard();
    }
}

// Function to simulate declining a request (you can replace this with actual logic)
function declineRequest(requestId) {
    const request = requests.find(request => request.id === requestId);
    if (request) {
        request.status = 'Declined';
        updateDashboard();
    }
}

// Function to simulate viewing a form (you can replace this with actual logic)
function viewForm(requestId) {
    // Add logic to handle viewing the form based on the request ID
    alert(`Viewing form for Request ID: ${requestId}`);
}

// Initialize the dashboard
updateDashboard();



document.addEventListener("DOMContentLoaded", function () {
    const articleSearchInput = document.getElementById("articleSearch");
    const articles = document.querySelectorAll(".item1");

    articleSearchInput.addEventListener("input", function () {
        const searchTerm = articleSearchInput.value.toLowerCase();

        articles.forEach(function (article) {
            const articleTitle = article.querySelector(".t-op-nextlvl").textContent.toLowerCase();

            if (articleTitle.includes(searchTerm)) {
                article.style.display = "block";
            } else {
                article.style.display = "none";
            }
        });
    });
});