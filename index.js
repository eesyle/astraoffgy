const fetchReviewsUrl = 'usernameAndmessage.php';  
let reviews = [];
let usernames = [];

let currentPage = 1;
const reviewsPerPage = 6;

// Fetch the reviews and usernames
fetch(fetchReviewsUrl)
    .then(response => response.json())
    .then(data => {
        // Process the fetched data
        reviews = data.map(item => item.review);
        usernames = data.map(item => item.username);

        // Initialize the display of reviews
        displayReviews(currentPage);
    })
    .catch(error => console.error('Error fetching data:', error));

// Function to get a unique username
function getUniqueUsername() {
    if (usernames.length === 0) {
        console.error('No more usernames available');
        return 'Anonymous'; // Fallback if no usernames are available
    }
    
    const randomIndex = Math.floor(Math.random() * usernames.length);
    const username = usernames[randomIndex];
    usernames.splice(randomIndex, 1); // Remove the username from the array
    return username;
}

// Function to display reviews on the page
function displayReviews(page) {
    const reviewsContainer = document.getElementById('reviews-container');
    reviewsContainer.innerHTML = '';

    const start = (page - 1) * reviewsPerPage;
    const end = start + reviewsPerPage;
    const paginatedReviews = reviews.slice(start, end);

    paginatedReviews.forEach(review => {
        const reviewCard = document.createElement('div');
        reviewCard.classList.add('review-card');
        const uniqueUsername = getUniqueUsername(); // Get a unique username
        
        function getRandomTime() {
            const timeTypes = ['days', 'hours', 'minutes'];
            const randomTimeType = timeTypes[Math.floor(Math.random() * timeTypes.length)];
            const randomNumber = Math.floor(Math.random() * 10) + 1; // 1 to 10 days/hours/minutes
            return `${randomNumber} ${randomTimeType} ago`;
        }
        
        function getRandomRating() {
            const minRating = 3;
            const maxRating = 5;
            const randomRating = Math.floor(Math.random() * (maxRating - minRating + 1)) + minRating; // 3 to 5 stars
            return '★'.repeat(randomRating) + '☆'.repeat(maxRating - randomRating);
        }

        const commentTime = getRandomTime();
        const rating = getRandomRating();

        reviewCard.innerHTML = `
            <div class="review-card-header">
                <img class="avatar" src="avatar.png" alt="Avatar">
                <div class="name">${uniqueUsername}</div>
            </div>
            <div class="comment-time">${commentTime}</div>
            <p>${review}</p>
            <div class="rating">${rating}</div>
        `;
        reviewsContainer.appendChild(reviewCard);
    });

    document.getElementById('page-number').textContent = page;
}

function nextPage() {
    if (currentPage < Math.ceil(reviews.length / reviewsPerPage)) {
        currentPage++;
        displayReviews(currentPage);
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        displayReviews(currentPage);
    }
}
